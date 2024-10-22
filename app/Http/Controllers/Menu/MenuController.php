<?php
namespace App\Http\Controllers\Menu;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest\AddMenuItemRequest;
use App\Http\Requests\MenuRequest\CreateMenuRequest;
use App\Http\Requests\MenuRequest\StoreChoicesRequest;
use App\Http\Requests\MenuRequest\UpdateChoiceRequest;
use App\Http\Requests\MenuRequest\UpdateChoicesRequest;
use App\Http\Requests\MenuRequest\UpdateMenuItemRequest;
use App\Http\Requests\MenuRequest\UpdateMenuRequest;
use App\Http\Resources\MenuResources\MenuWithMenuItemResource;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use App\Services\Menu\MenuService;
use PHPUnit\TextUI\Help;
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
        $result=$this->menuService->createMenu($request->all(),$branch_id);
        if($result['success']){
            return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu created successfully',$result['menu']);
        }else{
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST,$result['error']);
        }
    }


    public function addMenuItem(AddMenuItemRequest $request,$menu_id){
        $result=$this->menuService->addMenuItem($request->all(),$menu_id);
        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Food item created successfully',$result);
    }




    public function getMenu($menu_id){
        $menu=Menu::findorfail($menu_id);
        return $menu;
    }

    public function getMenuwithMenuItem($menu_id){
        $menu_item=MenuItem::where('menu_id',$menu_id)
            ->with(['AssignedChoiceGroups.choiceGroup.choices']) // Assuming 'choiceGroups' and 'choiceItems' relationships exist
            ->get();
        $data = MenuWithMenuItemResource::collection($menu_item);
        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu with menu items with choices',$data);
    }

    public function updateMenu(UpdateMenuRequest $request,$menu_id)
    {
        $result=$this->menuService->updateMenu($menu_id,$request->only(['name']));
        if($result['success']){
            return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu updated successfully',$result['menu']);
        }
        else{ return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST,$result['error']);}
    }





    public function updateMenuItem(UpdateMenuItemRequest $request,$menu_item_id)
    {
        $result=$this->menuService->updateMenuItem($menu_item_id,$request->validated());
        if($result['success']){
            return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu item updated successfully',$result['menu_item']);
        }else{
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST,$result['error']);
        }
    }



    public function deleteMenu($menu_id){
        $menu=Menu::findorfail($menu_id);
        $menu->delete();
    }
    public function deleteMenuItem($menu_item_id){
        $menuItem=MenuItem::findorfail($menu_item_id);
        $menuItem->delete();

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu item deleted successfully',$menuItem);
    }

    public function menuWithItemCount(){
        $menuCount=$this->menuService->menuWithItemCount();
        return $menuCount;
    }




    public function getChoices()
    {
        $result=$this->menuService->getChoices();
        return $result;
    }

    public function getChoicesWithMenuItem($menu_item_id)
    {
        $result=$this->menuService->getChoicesWithMenuItem($menu_item_id);

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Menu item retrieved successfully',$result);


    }




}
