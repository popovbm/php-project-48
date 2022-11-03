<?php

namespace gendiff\Parser;

use Symfony\Component\Yaml\Yaml;

function getRealPath(string $filePath)
{
    $realFilePath = realpath($filePath);

    if (!file_exists($realFilePath)) {
        throw new Exception("{$realFilePath} is invalid file path");
    }

    return $realFilePath;
}

function parseFile(string $filePath)
{
    $filePath = getRealPath($filePath);
    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
    $fileContent = file_get_contents($filePath);

    switch ($fileExtension) {
        case 'json':
            return json_decode($fileContent, true);
        case 'yml':
        case 'yaml':
            return Yaml::parse($fileContent);
        default:
            throw new Exception("{$fileExtension} is invalid file format");
    }
}
