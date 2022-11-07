<?php

namespace Differ\Differ;

use function Differ\Parser\parseFile;
use function Differ\MakeAst\buildAst;
use function Differ\Formatters\formatResult;

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $file1Content = parseFile($pathToFile1);
    $file2Content = parseFile($pathToFile2);
    $astTree = buildAst($file1Content, $file2Content);

    return formatResult($astTree, $format);
}
