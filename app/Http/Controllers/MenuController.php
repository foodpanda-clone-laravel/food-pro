<?php

namespace App\Http\Controllers;

use App\DTO\AddonDTO;
use App\DTO\MenuDTO;
use App\DTO\MenuItemDTO;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
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
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }


    public function createMenu(CreateMenuRequest $request,$branch_id)
    {
        $result = $this->menuService->createMenu($request->getValidatedData(), $branch_id);

        // Handle success or failure
        if ($result['success']) {
            return Helpers::sendSuccessResponse(200, 'Menu created successfully', $result['menu']);
        } else {
            // Return an error response
            return Helpers::sendFailureResponse(400, $result['error']);
        }
        }

    public function addMenuItem(AddMenuItemRequest $request, $menu_id){

        // Call the service to add the menu item
        $result = $this->menuService->addMenuItem($request, $menu_id);

        // Handle success or failure
        if ($result['success']) {
            return Helpers::sendSuccessResponse(200, 'Menu item created successfully', $result['menuItem']);
        } else {
            // Return an error response
            return Helpers::sendFailureResponse(400, $result['error']);


    }
}

    public function getMenu($menu_id){
        $menu = Menu::findorfail($menu_id);
        return $menu;
    }

    public function addOns(AddOnRequest $request, $menu_item_id)
    {
        // Call the service to create the addon
        $result = $this->menuService->createAddon($request, $menu_item_id);
    
        // Handle success or failure
        if ($result['success']) {
            // Access the 'addon' key instead of 'menuItem'
            return Helpers::sendSuccessResponse(200, 'Addon created successfully', $result['addon']);
        } else {
            // Return an error response
            return Helpers::sendFailureResponse(400, $result['error']);
        }
    }
    
    public function updateMenu(UpdateMenuRequest $request, $menu_id)
    {
        // Call the service to update the menu
        $result = $this->menuService->updateMenu($menu_id, $request->only(['name', 'description']));

        // Handle success or failure
        if ($result['success']) {
            return Helpers::sendSuccessResponse(200, 'Menu updated successfully', $result['menu']);
        } else {
            return Helpers::sendFailureResponse(400, $result['error']);
        }
    }

    public function updateMenuItem(UpdateMenuItemRequest $request, $menu_item_id)
    {
        $result = $this->menuService->updateMenuItem($menu_item_id, $request->validated());

        // Handle success or failure
        if ($result['success']) {
            return Helpers::sendSuccessResponse(200, 'Menu item updated successfully', $result['menu_item']);
        } else {
            return Helpers::sendFailureResponse(400, $result['error']);
        }
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
