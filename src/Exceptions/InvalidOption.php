<?php

namespace Atakde\PSession\Exceptions;

class InvalidOption extends \Exception
{
    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct("Invalid php session option: $key");
    }
}
