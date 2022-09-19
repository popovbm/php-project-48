<?php

namespace gendiff\Differ;

function genDiff($pathToFile1, $pathToFile2)
{
    $file1 = file_get_contents($pathToFile1);
    $file2 = file_get_contents($pathToFile2);

    $decodeFile1 = json_decode($pathToFile1, true);
    $decodeFile2 = json_decode($pathToFile2, true);

    $mergeFiles = array_merge($decodeFile1, $decodeFile2);

    $filesKeys = array_keys($mergeFiles);

    sort($filesKeys);

    $toString = function ($val) {
        return trim(var_export($val, true), "'");
    };

    $diff = function ($keys) use ($decodeFile1, $decodeFile2, $toString) {
        $result = array_reduce($keys, function ($acc, $key) use ($decodeFile1, $decodeFile2, $toString) {
            if (!array_key_exists($key, $decodeFile1)) {
                $acc[] = "+ {$key}: {$toString($decodeFile2[$key])}";
            } elseif (!array_key_exists($key, $decodeFile2)) {
                $acc[] = "- {$key}: {$toString($decodeFile1[$key])}";
            } elseif ($decodeFile1[$key] === $decodeFile2[$key]) {
                $acc[] = "  {$key}: {$toString($decodeFile1[$key])}";
            } else {
                $acc[] = "- {$key}: {$toString($decodeFile1[$key])}";
                $acc[] = "+ {$key}: {$toString($decodeFile2[$key])}";
            }
            return $acc;
        }, []);

        return implode("\n", $result);
    };

    return $diff($filesKeys);
}

$doc = <<<DOC
gendiff -h

Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: stylish]
DOC;

require('../vendor/docopt/docopt/src/docopt.php');
$args = Docopt::handle($doc, array('version'=>'Naval Fate 2.0'));
foreach ($args as $k=>$v)
echo $k.': '.json_encode($v).PHP_EOL;