<?php

namespace genDiff\Formatters\Json;

function formatJson(array $astTree): string
{
    return json_encode($astTree);
}
