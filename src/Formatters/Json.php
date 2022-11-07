<?php

namespace Differ\Formatters\Json;

/**
 * @param array<mixed> $astTree
 * @return mixed
 */

function formatJson(array $astTree)
{
    return json_encode($astTree);
}
