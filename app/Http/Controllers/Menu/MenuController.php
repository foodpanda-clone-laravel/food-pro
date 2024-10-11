<?php

namespace App\Http\Controllers\Menu;

use App\DTO\AddonDTO;
use App\DTO\MenuDTO;
use App\DTO\MenuItemDTO;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest\AddMenuItemRequest;
use App\Http\Requests\MenuRequest\AddOnRequest;
use App\Http\Requests\MenuRequest\CreateMenuRequest;
use App\Http\Requests\MenuRequest\StoreChoicesRequest;
use App\Http\Requests\MenuRequest\UpdateMenuItemRequest;
use App\Http\Requests\MenuRequest\UpdateMenuRequest;
use App\Models\Addon;
use App\Models\Branch;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\RestaurantOwner;
use App\Services\Menu\MenuService;
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
    /**
     * Add a menu item to a menu
     *
     * @param AddMenuItemRequest $request
     * @param int $menu_id
     *
     * @return \Illuminate\Http\JsonResponse
     */


        $result = $this->menuService->addMenuItem($request->getValidatedData(), $menu_id);

       return ($result);


    }


    public function getMenu($menu_id){
        $menu = Menu::findorfail($menu_id);
        return $menu;
    }

    public function addOns(AddOnRequest $request, $menu_item_id)
    {
        // Call the service to create the addon
        $result = $this->menuService->createAddon($request->validationData(), $menu_item_id);
    
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

    public function storeChoices(StoreChoicesRequest $request, $menu_id)
{



        // Call the service to save the choice
        $result = $this->menuService->storeChoices($request->validationData(), $menu_id);
        $data = $result->getData(true); 

        return Helpers::sendSuccessResponse(200, 'Choices saved successfully', $data['data']);
}


        }


        
