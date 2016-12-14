<?php

namespace Fgms\Tests\Yaml;

class ValueWrapperTest extends \PHPUnit_Framework_TestCase
{
    private $yaml;

    protected function setUp()
    {
        $yaml = "foo: bar\r\nbaz:\r\n    - quux\r\n    -corge";
        $this->yaml = new \Fgms\Yaml\ValueWrapper(
            (object)[
                'foo' => 'bar',
                'baz' => ['quux','corge']
            ],
            $yaml
        );
    }

    public function testRaiseMissing()
    {
        $this->expectException(\Fgms\Yaml\Exception\MissingException::class);
        $this->yaml->getString('bar');
    }

    public function testRaiseTypeMismatch()
    {
        $this->expectException(\Fgms\Yaml\Exception\TypeMismatchException::class);
        $this->yaml->getString('baz');
    }

    public function testWrapImpl()
    {
        $arr = $this->yaml->getArray('baz');
        $this->assertInstanceOf(\Fgms\Yaml\ValueWrapper::class,$arr);
    }
}
