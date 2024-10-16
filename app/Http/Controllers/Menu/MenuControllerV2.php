<?php

namespace App\Http\Controllers\Menu;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Requests\MenuRequest\AddChoiceGroupRequest;
use App\Http\Requests\MenuRequest\AddMenuItemRequest;
use App\Http\Requests\MenuRequest\AddOnRequest;
use App\Http\Requests\MenuRequest\CreateMenuRequest;
use App\Http\Requests\MenuRequest\RequireChoiceGroupIdRequest;
use App\Http\Requests\MenuRequest\StoreChoicesRequest;
use App\Http\Requests\MenuRequest\UpdateChoiceGroupRequest;
use App\Http\Requests\MenuRequest\UpdateMenuItemRequest;
use App\Http\Requests\MenuRequest\UpdateMenuRequest;
use App\Http\Requests\ValidateVariationRequest;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use App\Services\Menu\MenuServiceV2;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuControllerV2 extends Controller
{

    protected $menuService;

    public function __construct(MenuServiceV2 $menuService)
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

    public function addChoiceGroup(Request $request){
        $data = $request->all();
        $result = $this->menuService->addChoiceGroup($data);
    }
    public function addChoiceItem(Request $request){

        $data = $request->all();
        $result = $this->menuService->addChoiceItem($data);
        return response($result);
    }
    public function getChoiceGroupById(Request $request){
        $result = $this->menuService->getChoiceGroupById($request->id);
        return response($result);
    }
    public function assignChoiceGroup(Request $request){
        $result = $this->menuService->assignChoiceGroup($request->all());
        return response($result);
    }
    public function getAllChoiceGroups(){
        $result = $this->menuService->getAllChoiceGroupsByRestaurant();
        return Helpers::sendSuccessResponse(200,'All choice Groups', $result);
    }
    public function deleteChoiceGroup(RequireChoiceGroupIdRequest $request){
        $result = $this->menuService->deleteChoiceGroup($request->all());
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'deleted choice group successfully');
    }
    public function updateChoiceGroup(Request $request){

    }
    public function updateChoiceItem(UpdateChoiceGroupRequest $request){
        $data = $request->getValidatedData();
        $result = $this->menuService->updateChoiceGroup($data);
        if(!$result){

            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Updated choice group successfully', $result);
        }
        else{
            return Helpers::sendFailureResponse(500, 'internal server error');
        }
    }
    public function createChoiceGroup(AddChoiceGroupRequest $request){
        $result  = $this->menuService->createVariationV2($request->all());
        if(!$result){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'internal srever error');
        }
        else{
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'created choice group successfully');

        }
    }


}



