<?php

namespace Differ\Differ;

use function genDiff\Parser\parseFile;
use function genDiff\MakeAst\buildAst;
use function genDiff\Formatters\formatResult;

function genDiff($pathToFile1, $pathToFile2, $format = 'stylish')
{
    $file1Content = parseFile($pathToFile1);
    $file2Content = parseFile($pathToFile2);
    $astTree = buildAst($file1Content, $file2Content);

    return formatResult($astTree, $format);
}
