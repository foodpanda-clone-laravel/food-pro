<?php

namespace App\Http\Controllers;

use App\DTO\AddonDTO;
use App\DTO\MenuDTO;
use App\DTO\MenuItemDTO;
use App\Models\Addon;
use App\Models\Branch;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\RestaurantOwner;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function createMenu(Request $request,$branch_id)
    {
        $user = auth()->user();

        // Find the restaurant owner
        $owner = RestaurantOwner::findOrFail($user->id);

        // Find the restaurant associated with the owner
        $restaurant = Restaurant::findOrFail($owner->owner_id);

        // Check if the specified branch belongs to the restaurant
        $branch = Branch::where('restaurant_id', $restaurant->id)
                        ->where('id', $branch_id)
                        ->firstOrFail(); // Throws an exception if branch is not found

        // Create a new MenuDTO instance
        $menu = new MenuDTO(
            restaurant_id: $restaurant->id,
            name: $request->name,
            description: $request->description,
            branch_id: $branch->id // Use validated branch ID
        );

        // Create the menu in the database
        Menu::create($menu->toArray());

        


    }

    public function addMenuItem($menu_id, Request $request){

        $menu=Menu::findorfail($menu_id);

        $menuItem= new MenuItemDTO(
            menu_id: $menu->id,
            name: $request->name,
            price: $request->price,
            category: $request->category,
            serving_size: $request->serving_size,
            image_path: $request->image_path,
            discount: $request->discount
        );

        MenuItem::create($menuItem->toArray());





    }

    public function getMenu($menu_id){
        $menu = Menu::findorfail($menu_id);
        return $menu;
    }

    public function addOns($menu_id,$menu_item_id, Request $request){
        $menu = Menu::findorfail($menu_id);
        $menu_item = MenuItem::where('menu_id', $menu_id)->findOrFail($menu_item_id);
        $addOn= new AddonDTO(
            menu_item_id: $menu_item->id,
            name: $request->name,
            category: $request->category,
            price: $request->price
        );

        Addon::create($addOn->toArray());

        

        
    }

    public function updateMenu($menu_id, Request $request){
        $menu = Menu::findorfail($menu_id);
        $menu->update($request->validated());
    }


    public function updateMenuItem($menu_id, $menu_item_id, Request $request){
        $menu = Menu::findorfail($menu_id);
        $menu_item = MenuItem::where('menu_id', $menu_id)->findOrFail($menu_item_id);
        $menu_item->update($request->validated());
    }

    public function deleteMenu($menu_id){
        $menu = Menu::findorfail($menu_id);
        $menu->delete();
    }

    public function deleteMenuItem($menu_id, $menu_item_id){
        $menu = Menu::findorfail($menu_id);
        $menu_item = MenuItem::where('menu_id', $menu_id)->findOrFail($menu_item_id);
        $menu_item->delete();
    }



    
}
