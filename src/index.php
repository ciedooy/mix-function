<?php

function mix($path, $manifestDirectory = '')
{
    static $manifest;

    if (strpos($path, '/') !== 0) {
        $path = "/{$path}";
    }

    if ($manifestDirectory && strpos($manifestDirectory, '/') !== 0) {
        $manifestDirectory = "/{$manifestDirectory}";
    }

    if (!$manifest) {
        $manifestPath = $manifestDirectory . '/mix-manifest.json';

        if (!file_exists($manifestPath)) {
            throw new Exception('The Mix manifest does not exist.');
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
    }

    if (!array_key_exists($path, $manifest)) {
        throw new Exception("Unable to locate Mix file: {$path}.");
    }

    if (file_exists($manifestDirectory . '/hot')) {
        return "http://localhost:8080{$manifest[$path]}";
    }

    return $manifest[$path];
}