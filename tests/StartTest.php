<?php

use Atakde\PSession\PSession;
use PHPUnit\Framework\TestCase;

class StartTest extends TestCase
{
    public function testStart()
    {
        $session = new PSession();
        $this->assertTrue($session->start());
        $this->assertTrue($session->isStarted());
        $this->assertFalse($session->isNotStarted());
        $this->assertTrue(isset($_SESSION));
    }
}
