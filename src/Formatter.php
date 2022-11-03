<?php

namespace genDiff\Formatter;

use function genDiff\Formatters\Stylish\format;

function formatResult($astTree, $format)
{
    switch ($format) {
        case 'stylish':
            return format($astTree);
        default:
            throw new Exception("{$format} is invalid format");
    }
}
