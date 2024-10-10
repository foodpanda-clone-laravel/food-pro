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
    public ?float $discount=null; 

    public function __construct($data) {
        // Check if data keys exist, and if not, set defaults or throw an exception
        $this->menu_id = $data["menu_id"];
        $this->name = $data["name"] ;
        $this->price = $data["price"] ;
        $this->category = $data["category"];
        $this->serving_size = $data["serving_size"] ;
        $this->image_path = $data["image_path"] ;
        $this->discount = $data["discount"] ?? null;  // discount is nullable, so default to null
    }
}

