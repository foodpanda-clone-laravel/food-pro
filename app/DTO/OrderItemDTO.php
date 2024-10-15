<?php

namespace App\DTO;

class OrderItemDTO extends BaseDTO
{
    public int $order_id;
    public int $menu_item_id;
    public int $quantity;
    public float $item_price;
    public float $addon_price;
    public float $total_price;
    public string $addon_name;

    public function __construct(array $data) {
        $this->order_id = $data['order_id'];
        $this->menu_item_id = $data['menu_item_id'];
        $this->quantity = $data['quantity'];
        $this->item_price = $data['item_price'];
        $this->addon_price = $data['addon_price'];
        $this->total_price = $data['total_price'];
        $this->addon_name = $data['addon_name'];
    }
}
