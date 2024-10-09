<?php

namespace App\DTO;

class AddonDTO extends BaseDTO
{
    public string $name;            // The name of the addon
    public string $category;        // The category of the addon
    public int $menu_item_id;       // The ID of the associated menu item
    public float $price;            // The price of the addon

/*************  ✨ Codeium Command ⭐  *************/
    /**
     * RewardDTO constructor.
     *
     * @param float $points
     * @param int $user_id
     * @param int $badge_id
     * @param \DateTime|null $expired_at
     */
/******  6d76c4d4-8531-4502-927c-8d9a611638e1  *******/    public function __construct(
        string $name,
        string $category,
        int $menu_item_id,
        float $price
    ) {
        $this->name = $name;
        $this->category = $category;
        $this->menu_item_id = $menu_item_id;
        $this->price = $price;
    }
}
