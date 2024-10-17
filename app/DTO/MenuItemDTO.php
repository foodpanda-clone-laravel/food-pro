<?php

namespace App\DTO;

class MenuItemDTO extends BaseDTO
{
    public int $menu_id;
    public string $name;
    public float $price;
    public ?string $description;
    public mixed $variation_id; // Keep this as an array
    public ?string $image_file;


    public function __construct(array $data) {



        $this->menu_id = $data["menu_id"];
        $this->name = $data["name"];
        $this->price = $data["price"];
        $this->description = $data["description"] ?? null;
        $this->image_file = $data["image_file"] ?? null;

        // Directly assign variation_id as an array
            $this->variation_id = json_encode($data["variation_id"]) ?? null; // This can be an array or null
    }
}
