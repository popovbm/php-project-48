<?php

namespace genDiff\Formatters\Stylish;

function format($astTree, $depth = 0)
{
    $indent = str_repeat('    ', $depth);

    $lines = array_map(function ($node) use ($indent, $depth) {

        ['status' => $status, 'key' => $key, 'value1' => $value, 'value2' => $value2] = $node;

        $normalizeValue1 = (is_array($value)) ? format($value, $depth + 1) : $value;

        switch ($status) {
            case 'nested':
            case 'unchanged':
                return "{$indent}    {$key}: {$normalizeValue1}";
            case 'added':
                return "{$indent}  + {$key}: {$normalizeValue1}";
            case 'deleted':
                return "{$indent}  - {$key}: {$normalizeValue1}";
            case 'changed':
                $normalizeValue2 = (is_array($value2)) ? format($value2, $depth + 1) : $value2;
                return "{$indent}  - {$key}: {$normalizeValue1}\n{$indent}  + {$key}: {$normalizeValue2}";
            default:
                throw new Exception("Unknown node status: {$status}");
        }
    }, $astTree);
    $result = ["{", ...$lines, "{$indent}}"];
    return implode("\n", $result);
}
