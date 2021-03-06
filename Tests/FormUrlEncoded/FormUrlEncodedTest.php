<?php

namespace Fgms\Tests\FormUrlEncoded;

class FormUrlEncodedTest extends \PHPUnit_Framework_TestCase
{
    public function testDecodeEmpty()
    {
        $obj = \Fgms\FormUrlEncoded\FormUrlEncoded::decode('');
        $this->assertCount(0,get_object_vars($obj));
    }

    public function testDecode()
    {
        $obj = \Fgms\FormUrlEncoded\FormUrlEncoded::decode('foo=bar&baz=quux');
        $vars = get_object_vars($obj->unwrap());
        $this->assertCount(2,$vars);
        $this->assertArrayHasKey('foo',$vars);
        $this->assertSame('bar',$obj->foo);
        $this->assertArrayHasKey('baz',$vars);
        $this->assertSame('quux',$obj->baz);
    }

    public function testDecodeArray()
    {
        $obj = \Fgms\FormUrlEncoded\FormUrlEncoded::decode('foo=bar&baz=quux&baz=corge&baz=hello%20world');
        $vars = get_object_vars($obj->unwrap());
        $this->assertCount(2,$vars);
        $this->assertArrayHasKey('foo',$vars);
        $this->assertSame('bar',$obj->foo);
        $this->assertArrayHasKey('baz',$vars);
        $arr = $obj->baz;
        $this->assertCount(3,$arr);
        $this->assertArrayHasKey(0,$arr);
        $this->assertSame('quux',$arr[0]);
        $this->assertArrayHasKey(1,$arr);
        $this->assertSame('corge',$arr[1]);
        $this->assertArrayHasKey(2,$arr);
        $this->assertSame('hello world',$arr[2]);
    }

    public function testDecodePlus()
    {
        $obj = \Fgms\FormUrlEncoded\FormUrlEncoded::decode('foo=bar+baz');
        $vars = get_object_vars($obj->unwrap());
        $this->assertCount(1,$vars);
        $this->assertArrayHasKey('foo',$vars);
        $this->assertSame('bar baz',$obj->foo);
    }

    public function testDecodeTypeMismatch()
    {
        $obj = \Fgms\FormUrlEncoded\FormUrlEncoded::decode('foo=bar&baz=quux&baz=corge&baz=hello%20world');
        $this->expectException(\Fgms\FormUrlEncoded\Exception\TypeMismatchException::class);
        $obj->getString('baz');
    }

    public function testDecodeMissing()
    {
        $obj = \Fgms\FormUrlEncoded\FormUrlEncoded::decode('');
        $this->expectException(\Fgms\FormUrlEncoded\Exception\MissingException::class);
        $obj->getString('foo');
    }

    public function testDecodeBad()
    {
        $this->expectException(\Fgms\FormUrlEncoded\Exception\DecodeException::class);
        \Fgms\FormUrlEncoded\FormUrlEncoded::decode('foo');
    }
}
