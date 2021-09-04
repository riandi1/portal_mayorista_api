<?php

use App\Models\System\Parameter;

class ParametersSeeder extends \Illuminate\Database\Seeder
{
    protected $parameters = [
        "MEDIA_ALLOWED" => [
            "value" => '["regex:/image\/\.*/","regex:/video\/\.*/","application/pdf"]',
            "description" => "File formats allowed to uploads"
        ],
        "TEMPLATE_WELCOME_NOTIFICATION" => [
            "value" => '<p> {{$message}} </p>',
            "description" => "Template for welcome notification mail, (Vars: message, user)"
        ],
        "TEMPLATE_USER_NOTIFICATION_DEFAULT" => [
            "value" => '<p> {{$message}} </p>',
            "description" => "Default template for notifications of tickets, (Vars: message, ticket, user)"
        ]
    ];

    public function __construct()
    {
    }

    public function run()
    {
        foreach ($this->parameters as $code => $content) {
            $data = ['code' => $code, 'name' => $code];
            if (is_array($content)) {
                $data = array_merge($data, $content);
            } else if (is_string($content))
                $data['value'] = $content;
            $record = Parameter::query()->where('code', '=', $data['code'])->first();
            if (!is_null($record)) {
                $record->fill($data);
                $record->save();
            } else
                Parameter::updateOrCreate($data);
        }
    }
}
