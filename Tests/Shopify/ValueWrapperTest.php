<?php

namespace Fgms\Tests\Shopify;

class ValueWrapperTest extends \PHPUnit_Framework_TestCase
{
    private $wrapper;

    protected function setUp()
    {
        $inner = new \Fgms\ValueWrapper\ValueWrapperImpl((object)[
            'foo' => 'bar'
        ]);
        $this->wrapper = new \Fgms\Shopify\ValueWrapper($inner);
    }

    public function testMissing()
    {
        $this->expectException(\Fgms\Shopify\Exception\MissingException::class);
        $this->wrapper->getString('baz');
    }

    public function testTypeMismatch()
    {
        $this->expectException(\Fgms\Shopify\Exception\TypeMismatchException::class);
        $this->wrapper->getInteger('foo');
    }

    public function testCreate()
    {
        $obj = \Fgms\Shopify\ValueWrapper::create('{"foo":"bar"}');
        $this->assertSame('bar',$obj->getString('foo'));
    }

    public function testCreateInvalid()
    {
        $this->expectException(\Fgms\Shopify\Exception\DecodeException::class);
        \Fgms\Shopify\ValueWrapper::create('{');
    }

    public function testCreateNonObject()
    {
        $this->expectException(\Fgms\Shopify\Exception\DecodeException::class);
        \Fgms\Shopify\ValueWrapper::create('[]');
    }
}
