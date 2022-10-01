<?php

namespace gendiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filePath)
{
    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
    $fileContent = file_get_contents($filePath);

    switch ($fileExtension) {
        case 'json':
            return json_decode($fileContent, true);
        case 'yml':
            return Yaml::parse($fileContent);
        case 'yaml':
            return Yaml::parse($fileContent);
        default:
            echo 'wrong file format';
            return;
    }
}
