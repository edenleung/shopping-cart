<?php

namespace xiaodi\ShoppingCart;

use Illuminate\Support\Collection;

class Cart
{
    protected $session;

    protected $name = 'shopping_cart';

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    protected function getCart()
    {
        $cart = $this->session[$this->name];

        return $cart instanceof Collection ? $cart : new Collection();
    }

    protected function insertRow($goods_id, $qty, $price, $sku = [])
    {
        return new CartItem(array_merge(['goods_id' => $goods_id, 'qty' => $qty, 'price' => $price], $sku));
    }

    public function add($goods_id, $qty, $price, $sku = [])
    {
        $row = $this->insertRow($goods_id, $qty, $price, $sku);

        $this->putRow($goods_id, $row);
    }

    protected function putRow($id, $row)
    {
        $cart = $this->getCart();
        $cart->put($id, $row);
        $this->save($cart);
    }

    protected function makeRowId($id, $params = [])
    {
        return md5($id . serialize($params));
    }

    public function save($cart)
    {
        $this->session[$this->name] = $cart;
    }

    public function clear()
    {
        $this->save(null);
    }

    public function total()
    {
        $total = 0;

        $cart = $this->getCart();

        if ($cart->isEmpty()) {
            return $total;
        }

        foreach ($cart as $row) {
            $total += $row->qty * $row->price;
        }

        return $total;
    }

    public function updatePrice($rowId, $price)
    {
        $cart = $this->getCart();
        $row = $cart->get($rowId);
        $row->put('price', $price);
        $this->putRow($rowId, $row);
    }

    public function updateQty($rowId, $qty)
    {
        $cart = $this->getCart();
        $row = $cart->get($rowId);
        $row->put('qty', $row->qty + $qty);
        $this->putRow($rowId, $row);
    }
}
