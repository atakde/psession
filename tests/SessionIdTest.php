<?php

use Atakde\PSession\PSession;
use PHPUnit\Framework\TestCase;

class SessionIdTest extends TestCase
{
    public function testSessionId()
    {
        $session = new PSession();
        $session->start();

        $_COOKIE['PHPSESSID'] = $session->getId();
        
        $this->assertEquals(session_id(), $session->getId());
        $this->assertEquals(session_name(), $session->getName());
        $this->assertEquals(session_id(), $_COOKIE[session_name()]);
        $this->assertEquals(session_id(), $_COOKIE[$session->getName()]);
    }
}
