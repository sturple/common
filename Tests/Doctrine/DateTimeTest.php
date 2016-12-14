<?php

namespace Fgms\Tests\Doctrine;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testToDoctrine()
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('America/Vancouver');
        $dt->setTimezone($tz);
        $ndt = \Fgms\Doctrine\DateTime::toDoctrine($dt);
        //	Ensures clone occurs
        $this->assertNotSame($dt,$ndt);
        $this->assertSame('America/Vancouver',$dt->getTimezone()->getName());
        $this->assertSame('UTC',$ndt->getTimezone()->getName());
    }

    public function testFromDoctrine()
    {
        $tz = new \DateTimeZone('America/Vancouver');
        $dt = \DateTime::createFromFormat('Y-m-d H:i:s','2016-12-14 00:20:00',$tz);
        $ndt = \Fgms\Doctrine\DateTime::fromDoctrine($dt);
        $this->assertNotSame($dt,$ndt);
        $this->assertNotSame($dt->getTimestamp(),$ndt->getTimestamp());
        $this->assertSame($dt->getTimestamp() - 28800,$ndt->getTimestamp());
    }

    public function testFromDoctrineNoClone()
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('UTC');
        $dt->setTimezone($tz);
        $ndt = \Fgms\Doctrine\DateTime::fromDoctrine($dt);
        $this->assertSame($dt,$ndt);
    }
}
