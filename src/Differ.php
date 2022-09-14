<?php

namespace gendiff\Differ;

function genDiff($pathToFile1, $pathToFile2)
{
    $file1 = json_decode($pathToFile1, true);
    $file2 = json_decode($pathToFile2, true);

    $mergeFiles = array_merge($file1, $file2);

    $keys = array_keys($mergeFiles);

    sort($keys);

    $result = array_reduce($keys, function ($acc, $key) use ($file1, $file2) {
        if (!array_key_exists($key, $file2)) {
            $acc[] = "- {$key}: {$file1[$key]}";
        } elseif (!array_key_exists($key, $file1)) {
            $acc[] = "+ {$key}: {$file2[$key]}";
        } elseif ($file1[$key] === $file2[$key]) {
            $acc[] = "  {$key}: {$file1[$key]}";
        } else{
            $acc[] = "- {$key}: {$file1[$key]}";
            $acc[] = "+ {$key}: {$file2[$key]}";
        }
        return $acc;
    }, []);

    return $result;
}