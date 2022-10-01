<?php

namespace gendiff\tests\YamlTest;

use PHPUnit\Framework\TestCase;

use function gendiff\Differ\genDiff;

class YamlTest extends TestCase
{
    public function testToPlain(): void
    {
        function getFixtureFullPath($fixtureName)
        {
            $parts = [__DIR__, 'fixtures', $fixtureName];
            return realpath(implode('/', $parts));
        }

        $file1 = getFixtureFullPath('/file1.yml');
        $file2 = getFixtureFullPath('/file2.yml');
        $result = file_get_contents(getFixtureFullPath('resultPlain.txt'));

        $this->assertFileExists($file1);
        $this->assertFileExists($file2);
        $this->assertEquals(genDiff($file1, $file2), $result);
    }
}
