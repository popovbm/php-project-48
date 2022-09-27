<?php

namespace gendiff\Differ;

function genDiff($pathToFile1, $pathToFile2)
{
    $pathToFile1 = realpath($pathToFile1);
    $pathToFile2 = realpath($pathToFile2);
    if (!file_exists($pathToFile1) || !file_exists($pathToFile2)) {
        return false;
    }

    $file1 = file_get_contents($pathToFile1);
    $file2 = file_get_contents($pathToFile2);

    $decodeFile1 = json_decode($file1, true);
    $decodeFile2 = json_decode($file2, true);

    $mergeFiles = array_merge($decodeFile1, $decodeFile2);

    $filesKeys = array_keys($mergeFiles);

    sort($filesKeys);

    $toString = function ($val) {
        return trim(var_export($val, true), "'");
    };

    $diff = function ($keys) use ($decodeFile1, $decodeFile2, $toString) {
        $result = array_reduce($keys, function ($acc, $key) use ($decodeFile1, $decodeFile2, $toString) {
            if (!array_key_exists($key, $decodeFile1)) {
                $acc[] = "  + {$key}: {$toString($decodeFile2[$key])}";
            } elseif (!array_key_exists($key, $decodeFile2)) {
                $acc[] = "  - {$key}: {$toString($decodeFile1[$key])}";
            } elseif ($decodeFile1[$key] === $decodeFile2[$key]) {
                $acc[] = "    {$key}: {$toString($decodeFile1[$key])}";
            } else {
                $acc[] = "  - {$key}: {$toString($decodeFile1[$key])}";
                $acc[] = "  + {$key}: {$toString($decodeFile2[$key])}";
            }
            return $acc;
        }, []);

        return implode("\n", $result);
    };

    return "{\n{$diff($filesKeys)}\n}";
}
