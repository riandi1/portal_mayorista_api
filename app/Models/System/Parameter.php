<?php

namespace App\Models\System;

use App\Models\Model;
use Schema;

class Parameter extends Model
{

    protected $fillable = ['id', 'code', 'value', 'name', 'description'];

    protected $dates = ['deleted_at'];

    public static function byCode($code, $only_value = true, $default = null)
    {
        if(Schema::hasTable('parameters')) {
            $object = self::where('code', '=', strtoupper($code))->first();
            if ($only_value) {
                if (is_null($object) || (!is_null($object) && is_null($object->value)))
                    return $default;
                return $object->value;
            }
            return $object;
        }
        return null;
    }
}
