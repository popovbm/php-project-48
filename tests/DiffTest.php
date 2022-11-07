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
            $parts = [__DIR__, 'fixtures', $fixtureName];
            return realpath(implode('/', $parts));
    }

    /**
     * @return array<string>
     */
    private function getFullPaths()
    {
        $fileJson = $this->getFixtureFullPath('/file1.json');
        $fileYml = $this->getFixtureFullPath('/file2.yml');
        return [$fileJson, $fileYml];
    }

    public function testStylish(): void
    {
        $expectedResult = file_get_contents($this->getFixtureFullPath('resultStylish.txt'));
        [$fileJson, $fileYml] = $this->getFullPaths();

        $this->assertEquals(genDiff($fileJson, $fileYml), $expectedResult);
    }

    public function testPlain(): void
    {
        $expectedResult = file_get_contents($this->getFixtureFullPath('resultPlain.txt'));
        [$fileJson, $fileYml] = $this->getFullPaths();

        $this->assertEquals(genDiff($fileJson, $fileYml, 'plain'), $expectedResult);
    }

    public function testJson(): void
    {
        $expectedResult = file_get_contents($this->getFixtureFullPath('resultJson.txt'));
        [$fileJson, $fileYml] = $this->getFullPaths();

        $this->assertEquals(genDiff($fileJson, $fileYml, 'json'), $expectedResult);
    }
}
