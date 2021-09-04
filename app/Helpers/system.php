<?php

if (!function_exists("models")) {
    /**
     * @param null $models_path
     * @return array
     */
    function models($models_path = null)
    {
        if (is_null($models_path))
            $models_path = app_path('Models');
        $models = [];
        $results = scandir($models_path);
        foreach ($results as $result) {
            if ($result === '.' || $result === '..') continue;
            $path = "$models_path/$result";
            if (is_file($path)) {
                $sub_path = str_replace(app_path(), 'App', $path);
                $namespace = str_replace('/', '\\', preg_replace("/\.[^.]*$/", '', $sub_path));
                $models[] = $namespace;
            } else $models = array_merge($models, models($path));
        }
        return $models;
    }
}

if (!function_exists("models_map")) {

    function models_map()
    {
        $map = [];
        $namespaces = models();
        foreach ($namespaces as $namespace) {
            try {
                if (!class_exists($namespace)) continue;
                $class_name = class_basename($namespace);
                $map[$class_name] = $namespace;
            } catch (Exception $e) {
            }

        }
        return $map;
    }
}

if (!function_exists("model_namespace")) {

    function model_namespace($model_name)
    {
        $model_name = ucfirst($model_name);
        $namespaces = models_map();
        if (isset($namespaces[$model_name]))
            return $namespaces[$model_name];
        return null;
    }
}
