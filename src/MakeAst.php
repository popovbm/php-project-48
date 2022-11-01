<?php

namespace genDiff\MakeAst;


function makeNode(string $status, string $key, $value1, $value2 = null)
{
    return ['status' => $status, 'key' => $key, 'value1' => $value1, 'value2' => $value2];
}

function buildAst($contentFile1, $contentFile2)
{
    $file1Keys = array_keys($contentFile1);
    $file2Keys = array_keys($contentFile2);
    $keys = array_unique(array_merge($file1Keys, $file2Keys));
    sort($keys);

    return array_map(fn($key) => genAst($key, $contentFile1, $contentFile2), $keys);
}

function genAst($key, $contentFile1, $contentFile2)
{
    $value1 = $contentFile1[$key] ?? null;
    $value2 = $contentFile2[$key] ?? null;

    if (is_array($value1) && is_array($value2)) {
        return makeNode('nested', $key, buildAst($value1, $value2));
    }

    if (!array_key_exists($key, $contentFile1)) {
        return makeNode('added', $key, stringify($value2));
    }

    if (!array_key_exists($key, $contentFile2)) {
        return  makeNode('deleted', $key, stringify($value1));
    }

    if ($value1 !== $value2) {
        return makeNode('changed', $key, stringify($value1), stringify($value2));
    }

    if ($value1 === $value2) {
        return makeNode('unchanged', $key, $value1);
    }
}

function stringify($content)
{
    $iter = function ($content) use (&$iter) {
        if (!is_array($content)) {
             if ($content === null) {
                 return 'null';
             }
            return trim(var_export($content, true), "'");
        }

        $keys = array_keys($content);
        return array_map(function ($key) use ($content, $iter) {
            $value = (is_array($content[$key])) ? $iter($content[$key]) : $content[$key];

            return makeNode('unchanged', $key, $value);
        }, $keys);
    };

    return $iter($content);
}