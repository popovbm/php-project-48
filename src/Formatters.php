<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\formatStylish;
use function Differ\Formatters\Plain\formatPlain;
use function Differ\Formatters\Json\formatJson;

 /**
 * @param array<mixed> $astTree
 * @param string $format
 * @return string
 */
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
            throw new \Exception("{$format} is invalid format");
    }
}
