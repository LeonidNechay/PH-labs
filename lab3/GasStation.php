<?php

class GasStation
{
    public $id;
    public $address;
    public $name;
    public $liters;
    public $price;

    public function GasStation($id, $array) {
        $this->id = $id;
        $this->address = $array["address"];
        $this->name = $array["name"];
        $this->liters = $array["liters"];
        $this->price = $array["price"];
    }

    static function checkGasStation($array) {
        if(
            empty($array["address"]) ||
            empty($array["name"]) ||
            $array["liters"] < 0 ||
            $array["price"] < 0 ||
            !isset($array)
        )
        {
            return false;
        }
        return true;
    }
}