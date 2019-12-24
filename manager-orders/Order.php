<?php


class Order
{
    private $orderNumber;
    private $status;

    public function __construct($orderNumber, $status=null)
    {
        $this->orderNumber = $orderNumber;
        $this->status = $status;
    }

}