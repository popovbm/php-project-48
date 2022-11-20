<?php

namespace gendiff\tests\DiffTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DiffTest extends TestCase
{
    /**
     * @param string $fixtureName
     * @return string
     */
    private function getFixtureFullPath($fixtureName)
    {
        return __DIR__ . "/fixtures/" . $fixtureName;
    }

    /**
     * @dataProvider mainProvider
     * @param string $file1
     * @param string $file2
     * @param string $expectedResult
     * @param string $format
     * @return void
     */
    public function testTwoGendiffs($file1, $file2, $format, $expectedResult)
    {
        $fixture1 = $this->getFixtureFullPath($file1);
        $fixture2 = $this->getFixtureFullPath($file2);
        $diffResult = file_get_contents($this->getFixtureFullPath($expectedResult));
        $this->assertEquals(genDiff($fixture1, $fixture2, $format), $diffResult);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function mainProvider()
    {
        return [
            [
                'file1.json',
                'file2.json',
                'stylish',
                'resultStylish.txt'
            ],
            [
                'file1.yml',
                'file2.yml',
                'stylish',
                'resultStylish.txt'
            ],
            [
                'file1.json',
                'file2.json',
                'plain',
                'resultPlain.txt'
            ],
            [
                'file1.yml',
                'file2.yml',
                'plain',
                'resultPlain.txt'
            ],
            [
                'file1.json',
                'file2.json',
                'json',
                'resultJson.txt'
            ],
            [
                'file1.yml',
                'file2.yml',
                'json',
                'resultJson.txt'
            ],
        ];
    }
}
