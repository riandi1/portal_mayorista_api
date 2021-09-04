<?php

namespace App\Models\System;

use App\Models\Model;
use Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Binnacle extends Model
{

    public $relationships = ['user', 'target'];

    protected $fillable = [
        'id',
        'action',
        'target_type',
        'target_id',
        'user_id',
        'title',
        'message',
        'created_at'
    ];

    protected $dates = ["created_at"];

    public function target()
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param string $title
     * @param string $message
     * @param string $action
     * @param $target_model
     * @param $target_object
     * @return Binnacle
     */
    public static function write($title, $message, $action, $target_model, $target_object)
    {
        /** @var Model $instance */
        $instance = new $target_model();
        $model_name = join('', array_slice(explode('\\', $target_model), -1));
        if (method_exists($instance, 'getKeyName'))
            $target_key = $instance->getKeyName();
        $target_id = isset($target_key) ? $target_object[$target_key] : null;
        $binnacle = new Binnacle([
            'target_type' => $model_name,
            'action' => $action,
            'target_id' => $target_id,
            'user_id' => Auth::id(),
            'message' => $message ?: '',
            'title' => $title ?: ''
        ]);
        if ($binnacle->save())
            return $binnacle;
    }
}
