<?php

namespace xiaodi\ShoppingCart;

use ArrayAccess;

class SessionManager implements ArrayAccess
{
    public function __construct()
    {
        session_start();
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $_SESSION);
    }

    public function offsetSet($offset, $value)
    {
        $_SESSION[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($_SESSION[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($_SESSION[$offset]) ? $_SESSION[$offset] : null;
    }
}
