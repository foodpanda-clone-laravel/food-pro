<?php

namespace App\Http\Controllers;

use App\DTO\AddonDTO;
use App\DTO\MenuDTO;
use App\DTO\MenuItemDTO;
use App\Helpers\Helpers;
use App\Http\Requests\AddMenuItemRequest;
use App\Http\Requests\AddOnRequest;
use App\Http\Requests\CreateMenuRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Addon;
use App\Models\Branch;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\RestaurantOwner;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function createMenu(CreateMenuRequest $request,$branch_id)
    {
        $user = auth()->user();

    

        // Find the restaurant owner
        $owner = RestaurantOwner::where('user_id', $user->id)->firstOrFail();


        // Find the restaurant associated with the owner
        $restaurant = Restaurant::where('owner_id', $owner->id)->firstOrFail();


        // Check if the specified branch belongs to the restaurant
        $branch = Branch::where('restaurant_id', $restaurant->id)
                        ->where('id', $branch_id)
                        ->firstOrFail(); // Throws an exception if branch is not found

        $menu = new MenuDTO(
            restaurant_id: $restaurant->id,
            name: $request->name,
            description: $request->description,
            branch_id: $branch->id // Use validated branch ID
        );

        // Create the menu in the database
        $menu = Menu::create($menu->toArray());

        return Helpers::sendSuccessResponse(200, 'Menu created successfully', $menu);

        


    }

    public function addMenuItem(AddMenuItemRequest $request, $menu_id){

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

        $menu_item = MenuItem::create($menuItem->toArray());

        return Helpers::sendSuccessResponse(200, 'Menu item created successfully', $menu_item);








    }

    public function getMenu($menu_id){
        $menu = Menu::findorfail($menu_id);
        return $menu;
    }

    public function addOns( AddOnRequest $request,$menu_id,$menu_item_id){
        $menu = Menu::findorfail($menu_id);
        $menu_item = MenuItem::where('menu_id', $menu_id)->findOrFail($menu_item_id);
        $addOn= new AddonDTO(
            menu_item_id: $menu_item->id,
            name: $request->name,
            category: $request->category,
            price: $request->price
        );

       $addOn = Addon::create($addOn->toArray());

       return Helpers::sendSuccessResponse(200, 'Addon created successfully', $addOn);

        

        
    }

    public function updateMenu(UpdateMenuRequest $request, $menu_id){
        $menu = Menu::findOrFail($menu_id);

        $menu->update($request->only(['name', 'description']));
    
       return Helpers::sendSuccessResponse(200, 'Menu updated successfully', $menu);
    }

    public function updateMenuItem(UpdateMenuItemRequest $request, $menu_id, $menu_item_id)
    {
        // Find the menu
        $menu = Menu::findOrFail($menu_id);
    
        // Find the menu item within the specified menu
        $menu_item = MenuItem::where('menu_id', $menu_id)->findOrFail($menu_item_id);
    
        // Update the menu item with validated data
        $menu_item->update($request->validated());
    
        return response()->json([
            'message' => 'Menu item updated successfully.',
            'menu_item' => $menu_item,
        ]);
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
