<?php

namespace Fgms\Tests\Json;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        $this->assertSame('[]',\Fgms\Json\Json::encode([]));
    }

    public function testDecode()
    {
        $this->assertSame('aoeu',\Fgms\Json\Json::decode('"aoeu"'));
    }

    public function testDecodeObject()
    {
        $wrapper = \Fgms\Json\Json::decode('{"foo":"bar"}');
        $this->assertSame('bar',$wrapper->getString('foo'));
    }

    public function testDecodeObjectMissing()
    {
        $wrapper = \Fgms\Json\Json::decode('{}');
        $this->expectException(\Fgms\Json\Exception\MissingException::class);
        $wrapper->getString('foo'); //  There is no such key
    }

    public function testDecodeArray()
    {
        $wrapper = \Fgms\Json\Json::decode('["foo",5]');
        $this->assertSame('foo',$wrapper->getString(0));
        $this->assertSame(5,$wrapper->getInteger(1));
    }

    public function testDecodeArrayTypeMismatch()
    {
        $wrapper = \Fgms\Json\Json::decode('[5]');
        $this->expectException(\Fgms\Json\Exception\TypeMismatchException::class);
        $wrapper->getString(0); //  It's actually an integer
    }

    public function testDecodeFail()
    {
        $this->expectException(\Fgms\Json\Exception\DecodeException::class);
        \Fgms\Json\Json::decode('aoeu');
    }

    public function testDecodeArrayMismatch()
    {
        $this->expectException(\Fgms\Json\Exception\TypeMismatchException::class);
        \Fgms\Json\Json::decodeArray('{}');
    }

    public function testDecodeObjectMismatch()
    {
        $this->expectException(\Fgms\Json\Exception\TypeMismatchException::class);
        \Fgms\Json\Json::decodeObject('[]');
    }

    public function testDecodeStringArrayMismatch()
    {
        $this->expectException(\Fgms\Json\Exception\TypeMismatchException::class);
        \Fgms\Json\Json::decodeStringArray('[5]');
    }
}
