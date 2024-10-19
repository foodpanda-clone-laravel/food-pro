<?php

namespace App\Services\Menu;

use App\DTO\AddonDTO;
use App\DTO\Menu\MenuDTO;
use App\DTO\Menu\MenuItemDTO;
use App\DTO\VariationDTO;
use App\Interfaces\menu\MenuServiceInterface;
use App\Models\Menu\Addon;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use App\Models\Menu\Variation;
use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Restaurant;
use App\Models\User\RestaurantOwner;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class MenuService implements MenuServiceInterface
{
    public function getRestaurant()
    {
        $user = Auth::user();
        $owner = $user->restaurantOwner;
        $restaurant = Restaurant::where('owner_id', $owner->id)->firstOrFail();
        return $restaurant;
    }

    public function createMenu(array $data, $branch_id)
    {
        try {
            $user = Auth::user();
            $owner = RestaurantOwner::where('user_id', $user->id)->firstOrFail();
            $restaurant = Restaurant::where('owner_id', $owner->id)->firstOrFail();
            $branch = Branch::where('restaurant_id', $restaurant->id)
                ->where('id', $branch_id)
                ->firstOrFail();
            $data['branch_id'] = $branch->id;
            $data['restaurant_id'] = $restaurant->id;

            $menu = Menu::create((new MenuDTO($data))->toArray());
            return ['success' => true, 'menu' => $menu];
        } catch (Exception $e) {
            dd($e);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function addMenuItem(array $data, int $menu_id)
    {
        try {
            $menu = Menu::findOrFail($menu_id);
            $imagePath = $data['image_file']->store('menuitems', 'public'); // Save file to 'storage/app/public/logos'
            $data['image_file'] = $imagePath;
            $data['menu_id'] = $menu->id;
            $imagePath = $data['image_file']->store('menuitems', 'public'); // Save file to 'storage/app/public/logos'

            $data['image_file'] = $imagePath;
            $menuItem = MenuItem::create((new MenuItemDTO($data))->toArray());
            return ['success' => true, 'menuItem' => $menuItem];
        } catch (ModelNotFoundException $e) {
            return ['success' => false, 'error' => 'Menu not found'];
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function createAddon(array $data, int $menu_item_id)
    {
        try {
            $menu_item = MenuItem::findOrFail($menu_item_id);
            $data['menu_item_id'] = $menu_item->id;
            $addOn = Addon::create((new AddonDTO($data))->toArray());
            return ['success' => true, 'addon' => $addOn];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'Unable to create addon'];
        }
    }

    public function updateMenu(int $menu_id, array $data): array
    {
        try {
            $menu = Menu::findOrFail($menu_id);
            $menu->update($data);
            return ['success' => true, 'menu' => $menu];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'Unable to update menu'];
        }
    }

    public function updateMenuItem(int $menu_item_id, array $data): array
    {
        try {
            $menu_item = MenuItem::findOrFail($menu_item_id);
            $menu_item->update($data);
            return ['success' => true, 'menu_item' => $menu_item];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'Unable to update menu item: ' . $e->getMessage()];
        }
    }

    public function storeChoices(array $data)
    {
        $restaurant = $this->getRestaurant();
        $data['restaurant_id'] = $restaurant->id;
        if ($data['isChoice'] == 1) {
            $variation = Variation::create((new VariationDTO($data))->toArray());
            return response()->json([
                'success' => true,
                'message' => 'Variation saved successfully!',
                'data' => $variation,
            ]);
        } else {
            $addOn = Addon::create((new AddonDTO($data))->toArray());
            return response()->json([
                'success' => true,
                'message' => 'Addon saved successfully!',
                'data' => $addOn,
            ]);
        }
    }

    public function getChoices()
    {
        $restaurant = $this->getRestaurant();
        $variations = Variation::where('restaurant_id', $restaurant->id)->get();
        $addons = Addon::where('restaurant_id', $restaurant->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Choices retrieved successfully!',
            'data' => [
                'variations' => $variations,
                'addons' => $addons,
            ],
        ]);
    }

    public function updateChoices(array $data, int $variation_id): array
    {
        try {
            $variation = Variation::findOrFail($variation_id);
            $variation->update($data);
            return ['success' => true, 'variation' => $variation];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'Unable to update variation: ' . $e->getMessage()];
        }
    }

    public function menuWithItemCount()
    {
        $restaurant = $this->getRestaurant();
        $menus = Menu::where('restaurant_id', $restaurant->id)
            ->withCount('menuItems')
            ->get();
        return $menus;
    }

    public function getChoicesWithMenuItem($menu_item_id)
    {
        try {
            $menu_item = MenuItem::findOrFail($menu_item_id);
            $decodedChoices = json_decode($menu_item->variation_id, true);
            $addonIds = $decodedChoices['addons'] ?? [];
            $variationIds = $decodedChoices['choices'] ?? [];
            $addons = Addon::whereIn('id', $addonIds)->get();
            $variations = Variation::whereIn('id', $variationIds)->get();
            return [
                'success' => true,
                'menu_item' => $menu_item,
                'addons' => $addons,
                'variations' => $variations,
            ];
        } catch (ModelNotFoundException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
                }
    }
}
