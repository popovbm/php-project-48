<?php

namespace genDiff\Formatters;

use function genDiff\Formatters\Stylish\formatStylish;
use function genDiff\Formatters\Plain\formatPlain;

function formatResult($astTree, $format)
{
    switch ($format) {
        case 'stylish':
            return formatStylish($astTree);
        case 'plain':
            return formatPlain($astTree);
        default:
            throw new Exception("{$format} is invalid format");
    }
}
