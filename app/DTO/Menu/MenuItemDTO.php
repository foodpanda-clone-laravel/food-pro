<?php

namespace App\DTO\Menu;

use App\DTO\BaseDTO;

class MenuItemDTO extends BaseDTO
{
    public int $menu_id;
    public string $name;
    public float $price;
    public ?string $description;
    public mixed $variation_id; // Keep this as an array
    public ?string $image_file;


    public function __construct(array $data, $menu_id) {



        $this->menu_id = $menu_id;
        $this->name = $data["name"];
        $this->price = $data["price"];
        $this->description = $data["description"] ?? null;
        $this->image_path = $data["image_path"] ?? null;
        $this->serving_size = $data['serving_size'];

    }
}
