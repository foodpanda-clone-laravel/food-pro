<?php
namespace App\Http\Controllers\Menu;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest\AddMenuItemRequest;
use App\Http\Requests\MenuRequest\CreateMenuRequest;
use App\Http\Requests\MenuRequest\StoreChoicesRequest;
use App\Http\Requests\MenuRequest\UpdateChoicesRequest;
use App\Http\Requests\MenuRequest\UpdateMenuItemRequest;
use App\Http\Requests\MenuRequest\UpdateMenuRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\Menu\MenuService;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService=$menuService;
    }


    public function createMenu(CreateMenuRequest $request,$branch_id)
    {
        $result=$this->menuService->createMenu($request->getValidatedData(),$branch_id);
        if($result['success']){
            return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu created successfully',$result['menu']);
        }else{
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST,$result['error']);
        }
    }


    public function addMenuItem(AddMenuItemRequest $request,$menu_id){
        $result=$this->menuService->addMenuItem($request->getValidatedData(),$menu_id);
        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Food item created successfully',$result);
    }




    public function getMenu($menu_id){
        $menu=Menu::findorfail($menu_id);
        return $menu;
    }

    public function getMenuwithMenuItem($menu_id){
        $menu_item=MenuItem::where('menu_id',$menu_id)->get();
        return $menu_item;
    }

    public function updateMenu(UpdateMenuRequest $request,$menu_id)
    {
        $result=$this->menuService->updateMenu($menu_id,$request->only(['name']));
        if($result['success']){
            return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu updated successfully',$result['menu']);
        }
        else{ return Helpers::sendFailureResponse(400,$result['error']);}
    }





    public function updateMenuItem(UpdateMenuItemRequest $request,$menu_item_id)
    {
        $result=$this->menuService->updateMenuItem($menu_item_id,$request->validated());
        if($result['success']){
            return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu item updated successfully',$result['menu_item']);
        }else{
            return Helpers::sendFailureResponse(400,$result['error']);
        }
    }



    public function deleteMenu($menu_id){
        $menu=Menu::findorfail($menu_id);
        $menu->delete();
    }

    public function menuWithItemCount(){
        $menuCount=$this->menuService->menuWithItemCount();
        return $menuCount;
    }



    public function storeChoices(StoreChoicesRequest $request)
    {
        $result=$this->menuService->storeChoices($request->validationData());
        $data=$result->getData(true);
        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Choices saved successfully',$data['data']);
    }

    public function getChoices()
    {
        $result=$this->menuService->getChoices();
        return $result;
    }

    public function getChoicesWithMenuItem($menu_item_id)
    {
        $result=$this->menuService->getChoicesWithMenuItem($menu_item_id);
        if($result['success']){
            return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu item retrieved successfully',$result['menu_item']);
        }else{
            return Helpers::sendFailureResponse(400,$result['error']);
        }

    }

    public function updateChoices(UpdateChoicesRequest $request,$variation_id)
    {
        $result=$this->menuService->updateChoices($request->validationData(),$variation_id);
        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Choices updated successfully',$result);
    }


}
// public function addOns(AddOnRequest $request, $menu_item_id)
// {
//     // Call the service to create the addon
//     $result = $this->menuService->createAddon($request->validationData(), $menu_item_id);

//     // Handle success or failure
//     if ($result['success']) {
//         // Access the 'addon' key instead of 'menuItem'
//         return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Addon created successfully', $result['addon']);
//     } else {
//         // Return an error response
//         return Helpers::sendFailureResponse(400, $result['error']);
//     }
// }
