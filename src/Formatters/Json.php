<?php

namespace Differ\Formatters\Json;

/**
 * @param array<mixed> $astTree
 * @return string
 */

function formatJson(array $astTree): string
{
    return json_encode($astTree);
}
