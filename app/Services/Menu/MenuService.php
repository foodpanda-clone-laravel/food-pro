<?php

namespace App\Services\Menu;

use App\DTO\ChoiceGroup\AssignedChoiceGroupDTO;
use App\DTO\Menu\MenuDTO;
use App\DTO\Menu\MenuItemDTO;
use App\Http\Resources\MenuResources\MenuWithMenuItemResource;
use App\Interfaces\menu\MenuServiceInterface;
use App\Models\ChoiceGroup\AssignedChoiceGroup;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Restaurant;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $owner = $user->restaurantOwner;
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

    public function addMenuItem($data, int $menu_id)
    {
        try {
            DB::beginTransaction();
            $menu = Menu::findOrFail($menu_id);
            $imagePath = $data['image_file']->store('menuitems', 'public');
            $data['image_path'] = $imagePath;

            $menuItem = MenuItem::create((new MenuItemDTO($data, $menu_id))->toArray());
            $assignedChoiceGroups = [];
            if(isset($data['assigned_choices'])){
                $assignedChoices = json_decode($data['assigned_choices'], true);
                foreach ($assignedChoices as  $choice) {
                    $assignedChoiceGroups[] = [
                        'choice_group_id' =>$choice,
                        'menu_item_id' => $menuItem->id,
                    ];
                }

                // Bulk insert
                AssignedChoiceGroup::insert($assignedChoiceGroups);

            }
            DB::commit();
            return ['success' => true, 'menuItem' => $menuItem];
        }
        catch (ModelNotFoundException $e) {
            dd($e);
            DB::rollBack();
            return ['success' => false, 'error' => 'Menu not found'];
        } catch (Exception $e) {
            DB::rollBack();

            dd($e);
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

            $menu_item=MenuItem::where('id',$menu_item_id)
                ->with(['AssignedChoiceGroups.choiceGroup.choices'])->get(); // Assuming 'choiceGroups' and 'choiceItems' relationships exist
            $data = MenuWithMenuItemResource::collection($menu_item);
            return $data;
        } catch (ModelNotFoundException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
                }
    }
}
