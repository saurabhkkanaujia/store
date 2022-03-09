<?php

namespace App;

class Cart
{
    public $arr;
    public function __construct($cartData)
    {
        $this->arr = $cartData;
    }

    public function addToCart($id, $qty)
    {
        if (count($this->arr) == 0) {
            $toPush = ['id' => $id, 'qty' => $qty];
            array_push($this->arr, $toPush);
        } else {
            if ($this->arrayIncludes($id, $qty)) {
            } else {
                array_push($this->arr, ['id' => $id, 'qty' => $qty]);
            }
        }
    }

    public function arrayIncludes($id, $qty)
    {
        foreach ($this->arr as $key => $value) {
            if ($id == $this->arr[$key]['id']) {
                $this->arr[$key]["qty"] += $qty;
                return true;
            }
        }
        return false;
    }

    public function removeProduct($id)
    {
        foreach ($this->arr as $key => $value) {
            if ($id == $this->arr[$key]['id']) {
                array_splice($this->arr, $key, 1);
            }
        }
    }

    public function getCart()
    {
        return $this->arr;
    }
}
