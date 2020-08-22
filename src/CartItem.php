<?php

namespace xiaodi\ShoppingCart;

use Illuminate\Support\Collection;

class CartItem extends Collection
{
    public function __get($name)
    {
        return $this->get($name);
    }
}
