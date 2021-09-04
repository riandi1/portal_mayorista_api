<?php

if (!function_exists("xml_to_array")) {

    function xml_to_array($data)
    {
        $str = json_encode($data);
        $array = json_decode($str, true);
        return $array;
    }
}
