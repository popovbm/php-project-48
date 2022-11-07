<?php

namespace genDiff\Formatters\Plain;

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

function formatPlain(array $astTree, string $keyName = ''): string
{
    $lines = array_map(function ($node) use ($keyName) {

        ['status' => $status, 'key' => $key, 'value1' => $value, 'value2' => $value2] = $node;

        $newKeyName = $keyName === '' ? $key : "{$keyName}.{$key}";

        switch ($status) {
            case 'nested':
                return formatPlain($value, $newKeyName);
            case 'added':
                $value = normalizeValue($value);
                return "Property '{$newKeyName}' was added with value: {$value}";
            case 'deleted':
                return "Property '{$newKeyName}' was removed";
            case 'changed':
                $value = normalizeValue($value);
                $value2 = normalizeValue($value2);
                return "Property '{$newKeyName}' was updated. From {$value} to {$value2}";
            case 'unchanged':
                break;
            default:
                throw new Exception("Unknown node status: {$status}");
        }
    }, $astTree);
    $filteredResult = array_filter($lines);
    return implode("\n", $filteredResult);
}
