<?php

namespace App\Services\Menu;

use App\Interfaces\MenuServiceV2Interface;
use App\Models\AssignedChoiceGroup;
use App\Models\Choice;
use App\Models\ChoiceGroup;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuServiceV2 extends MenuBaseService implements MenuServiceV2Interface
{

    public function createMenu(array $data, $branch_id)
    {
        try {
            $restaurant = MenuBaseService::getRestaurant();
            $branch = Branch::where('restaurant_id', $restaurant->id)
                ->where('id', $branch_id)
                ->firstOrFail();
            $data['branch_id']=$branch->id;
            $data['restaurant_id']=$restaurant->id;
            $menu= Menu::create((new MenuDTO($data))->toArray());
            return ['success' => true, 'menu' => $menu];

        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function addMenuItem(array $data, int $menu_id)
    {
        try {
            // Find the menu
            $menu = Menu::findOrFail($menu_id);

            $data['menu_id']=$menu->id;
            $menuItem= MenuItem::create((new MenuItemDTO($data))->toArray());
            dd($menuItem);
            // Return the created menu item
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
            // Find the menu item
            $menu_item = MenuItem::findOrFail($menu_item_id);

            $data['menu_item_id']=$menu_item->id;


            $addOn = Addon::create((new AddonDTO($data))->toArray());

            return ['success' => true, 'addon' => $addOn]; // Return the addon
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'Unable to create addon'];
        }
    }



    public function updateMenu(int $menu_id, array $data): array
    {
        try {
            // Find the menu by its ID
            $menu = Menu::findOrFail($menu_id);

            // Update the menu with only name and description
            $menu->update($data);

            // Return success response
            return ['success' => true, 'menu' => $menu];
        } catch (Exception $e) {
            // Catch any exception and return failure response
            return ['success' => false, 'error' => 'Unable to update menu'];
        }
    }

    public function updateMenuItem(int $menu_item_id, array $data): array
    {
        try {
            // Find the menu item by its ID
            $menu_item = MenuItem::findOrFail($menu_item_id);

            // Update the menu item with the provided data
            $menu_item->update($data);

            // Return success response with updated menu item
            return ['success' => true, 'menu_item' => $menu_item];
        } catch (Exception $e) {
            // Catch any exception and return failure response
            return ['success' => false, 'error' => 'Unable to update menu item: ' . $e->getMessage()];
        }
    }


    public function addChoiceGroup($data){
        $restaurant = MenuBaseService::getRestaurant();
        $data['restaurant_id']=$restaurant->id;
        $choiceGroup= ChoiceGroup::create($data);
        return $choiceGroup;
    }
    public function addChoiceItem($data){
    // I want the menu item to add in the choice group , here I need validation check
        try{

            $choices = json_decode($data['choices'], true);
            $choicesToInsert = [];

            foreach ($choices as $choice) {
                $choicesToInsert[] = [
                    'choice_group_id' => $data['choice_group_id'],
                    'name' => $choice['name'],
                    'additional_price' => $choice['additional_price'],
                ];
            }
            $insertedChoices  = DB::table('choices')->insert($choicesToInsert);
            return $insertedChoices;
        }
        catch(\Exception $e){
            return false;
        }
    }
    public function assignChoiceGroup($data){
        // add validation for duplicate rows
        // add validation for
        $restaurant = MenuBaseService::getRestaurant();
        // data has menu item id
        // choice_group_id
        return AssignedChoiceGroup::create($data);
}
    public function getChoiceGroupById($id){
        return ChoiceGroup::where('id', $id)->first();
    }

    // function for viewing all choice groups a restaurant has created,
    // restricted access to restaurant owner only
    public function getAllChoiceGroupsByRestaurant(){
        $restaurant = MenuBaseService::getRestaurant();
        return $restaurant->load('choiceGroups.choices');
    }
    public function deleteChoiceGroup(){

    }
    public function updateChoiceGroup($data){
    }
    public function updateChoiceItem(){

    }
}
