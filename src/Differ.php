<?php

namespace Differ\Differ;

use function Functional\sort;
use function Differ\Parsers\parseFile;
use function Differ\Formatters\formatResult;

/**
 * @param string $pathToFile1
 * @param string $pathToFile2
 * @param string $format
 * @return string
 */
function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $file1Content = parseFile($pathToFile1);
    $file2Content = parseFile($pathToFile2);
    $astTree = buildAst($file1Content, $file2Content);

    return formatResult($astTree, $format);
}

/**
 * @param string $status
 * @param string $key
 * @param mixed $value1
 * @param mixed $value2
 * @return array<mixed>
 */
function makeNode(string $status, string $key, $value1, $value2 = null)
{
    return ['status' => $status, 'key' => $key, 'value1' => $value1, 'value2' => $value2];
}

/**
 * @param array<mixed> $contentFile1
 * @param array<mixed> $contentFile2
 * @return array<mixed>
 */
function buildAst(array $contentFile1, array $contentFile2): array
{
    $file1Keys = array_keys($contentFile1);
    $file2Keys = array_keys($contentFile2);
    $keys = array_unique(array_merge($file1Keys, $file2Keys));
    $sortedKeys = sort($keys, fn ($left, $right) => strcmp($left, $right));

    return array_map(fn($key) => genAst($key, $contentFile1, $contentFile2), $sortedKeys);
}

/**
 * @param string $key
 * @param array<mixed> $contentFile1
 * @param array<mixed> $contentFile2
 * @return array<mixed>
 */
function genAst(string $key, array $contentFile1, array $contentFile2): array
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

    return makeNode('unchanged', $key, $value1);
}

/**
 * @param mixed $content
 * @return mixed
 */
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
