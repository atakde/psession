<?php

use Atakde\PSession\PSession;
use PHPUnit\Framework\TestCase;

class SetRemoveTest extends TestCase
{
    public function testSetRemove()
    {
        $session = new PSession();
        $session->set('foo', 'bar');
        $this->assertEquals('bar', $session->get('foo'));

        $session->remove('foo');
        $this->assertEquals(null, $session->get('foo'));
    }

    public function testSetRemoveWithDefaultValue()
    {
        $session = new PSession();
        $session->set('foo', 'bar');
        $this->assertEquals('bar', $session->get('foo', 'baz'));

        $session->remove('foo');
        $this->assertEquals('baz', $session->get('foo', 'baz'));
    }

    public function testMagicSetRemove()
    {
        $session = new PSession();
        $session->foo = 'bar';
        $this->assertEquals('bar', $session->foo);
        $this->assertEquals('bar', $session->get('foo'));
        $this->assertEquals('bar', $_SESSION['foo']);

        unset($session->foo);
        $this->assertEquals(null, $session->foo);
        $this->assertEquals(null, $session->get('foo'));
        $this->assertEquals(false, isset($_SESSION['foo']));

        // __isset magic method
        $this->assertFalse(isset($session->foo));
        // __unset magic method
        unset($session->foo);
        $this->assertFalse(isset($session->foo));
    }
}
