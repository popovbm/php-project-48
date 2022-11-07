<?php

namespace Differ\Formatters\Plain;

/**
 * @param mixed $value
 * @return mixed
 */
function normalizeValue($value)
{
    if (!is_array($value)) {
        if ($value === 'null') {
            return $value;
        }
        if ($value === 'true' || $value === 'false') {
            return $value;
        }
        if (is_numeric($value)) {
            return $value;
        }
        return "'{$value}'";
    }
    return "[complex value]";
}

 /**
 * @param array<mixed> $astTree
 * @param string $keyName
 * @return string
 */
function formatPlain(array $astTree, string $keyName = ''): string
{
    $lines = array_map(function ($node) use ($keyName) {

        ['status' => $status, 'key' => $key, 'value1' => $value, 'value2' => $value2] = $node;

        $newKeyName = $keyName === '' ? $key : "{$keyName}.{$key}";

        switch ($status) {
            case 'nested':
                return formatPlain($value, $newKeyName);
            case 'added':
                $normalizeValue = normalizeValue($value);
                return "Property '{$newKeyName}' was added with value: {$normalizeValue}";
            case 'deleted':
                return "Property '{$newKeyName}' was removed";
            case 'changed':
                $normalizeValue = normalizeValue($value);
                $normalizeValue2 = normalizeValue($value2);
                return "Property '{$newKeyName}' was updated. From {$normalizeValue} to {$normalizeValue2}";
            case 'unchanged':
                break;
            default:
                throw new \Exception("Unknown node status: {$status}");
        }
    }, $astTree);
    $filteredResult = array_filter($lines);
    return implode("\n", $filteredResult);
}
