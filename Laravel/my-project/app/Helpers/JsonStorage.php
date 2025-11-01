<?php

namespace App\Helpers;

class JsonStorage
{
    public static function read($filename)
    {
        $path = storage_path("app/data/{$filename}.json");
        return collect(json_decode(file_get_contents($path)));
    }

    public static function write($filename, $data)
    {
        $path = storage_path("app/data/{$filename}.json");
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }
}
