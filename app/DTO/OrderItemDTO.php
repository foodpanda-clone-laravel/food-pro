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

    public function __construct(
        int $order_id,
        int $menu_item_id,
        int $quantity,
        float $item_price,
        float $addon_price,
        float $total_price,
        string $addon_name
    ) {
        $this->order_id = $order_id;
        $this->menu_item_id = $menu_item_id;
        $this->quantity = $quantity;
        $this->item_price = $item_price;
        $this->addon_price = $addon_price;
        $this->total_price = $total_price;
        $this->addon_name = $addon_name;
    }
}
