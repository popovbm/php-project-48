<?php

namespace genDiff\Formatters;

use function genDiff\Formatters\Stylish\formatStylish;
use function genDiff\Formatters\Plain\formatPlain;
use function genDiff\Formatters\Json\formatJson;

function formatResult(array $astTree, string $format): string
{
    switch ($format) {
        case 'stylish':
            return formatStylish($astTree);
        case 'plain':
            return formatPlain($astTree);
        case 'json':
            return formatJson($astTree);
        default:
            throw new Exception("{$format} is invalid format");
    }
}
