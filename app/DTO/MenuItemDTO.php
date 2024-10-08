<?php

namespace App\DTO;

class MenuItemDTO extends BaseDTO
{
    public int $menu_id;
    public string $name;
    public float $price;
    public string $category;
    public string $serving_size;
    public string $image_path;
    public ?float $discount; 

    public function __construct(
        int $menu_id,
        string $name,
        float $price,
        string $category,
        string $serving_size,
        string $image_path,
        ?float $discount =0
    ) {
        $this->menu_id = $menu_id;
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->serving_size = $serving_size;
        $this->image_path = $image_path;
        $this->discount = $discount;
    }
}
