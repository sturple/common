<?php

namespace Fgms\Tests\Swift;

class MockTransportTest extends \PHPUnit_Framework_TestCase
{
    private $swift;

    protected function setUp()
    {
        $this->swift = new \Fgms\Swift\MockTransport();
    }

    public function testIsStarted()
    {
        $this->assertTrue($this->swift->isStarted());
    }

    public function testSend()
    {
        $msg = new \Swift_Message();
        $this->swift->send($msg);
        $msgs = $this->swift->getMessages();
        $this->assertCount(1,$msgs);
        $this->assertArrayHasKey(0,$msgs);
        $this->assertSame($msg,$msgs[0]);
    }

    public function testRegisterPlugin()
    {
        $plugin = new \Swift_Plugins_AntiFloodPlugin();
        $this->expectException(\LogicException::class);
        $this->swift->registerPlugin($plugin);
    }
}
