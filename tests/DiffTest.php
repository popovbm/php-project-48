<?php

namespace gendiff\tests\DiffTest;

use PHPUnit\Framework\TestCase;

use function gendiff\Differ\genDiff;

class DiffTest extends TestCase
{
    private function getFixtureFullPath($fixtureName)
    {
            $parts = [__DIR__, 'fixtures', $fixtureName];
            return realpath(implode('/', $parts));
    }

    private function getFullPaths()
    {
        $file1Json = $this->getFixtureFullPath('/file1.json');
        $file2Json = $this->getFixtureFullPath('/file2.json');
        $file1Yml = $this->getFixtureFullPath('/file1.yml');
        $file2Yml = $this->getFixtureFullPath('/file2.yml');
        return [$file1Json, $file2Json, $file1Yml, $file2Yml];
    }

    public function testStylish(): void
    {
        $expectedResult = file_get_contents($this->getFixtureFullPath('resultStylish.txt'));
        [$file1Json, $file2Json, $file1Yml, $file2Yml] = $this->getFullPaths();

        $this->assertEquals(genDiff($file1Json, $file2Json), $expectedResult);
        $this->assertEquals(genDiff($file1Yml, $file2Yml), $expectedResult);
        $this->assertEquals(genDiff($file1Json, $file2Yml), $expectedResult);
    }

    public function testPlain(): void
    {
        $expectedResult = file_get_contents($this->getFixtureFullPath('resultPlain.txt'));
        [$file1Json, $file2Json, $file1Yml, $file2Yml] = $this->getFullPaths();

        $this->assertEquals(genDiff($file1Json, $file2Json, 'plain'), $expectedResult);
        $this->assertEquals(genDiff($file1Yml, $file2Yml, 'plain'), $expectedResult);
        $this->assertEquals(genDiff($file1Json, $file2Yml, 'plain'), $expectedResult);
    }
}
