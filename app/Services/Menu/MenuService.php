<?php

namespace App\Services\Menu;

use App\DTO\ChoiceGroup\AssignedChoiceGroupDTO;
use App\DTO\Menu\MenuDTO;
use App\DTO\Menu\MenuItemDTO;
use App\Helpers\Helpers;
use App\Http\Resources\MenuResources\MenuWithMenuItemResource;
use App\Interfaces\menu\MenuServiceInterface;
use App\Models\ChoiceGroup\AssignedChoiceGroup;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Restaurant;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuService implements MenuServiceInterface
{
    private function getRestaurant()
    {
        $user = Auth::user();
        $owner = $user->restaurantOwner;
        $restaurant = Restaurant::where('owner_id', $owner->id)->firstOrFail();
        return $restaurant;
    }

    public function createMenu(array $data, $branch_id)
    {
        try {
           
            $restaurant = $this->getRestaurant();
            $branch = Branch::where('restaurant_id', $restaurant->id)
                ->where('id', $branch_id)
                ->firstOrFail();
            $data['branch_id'] = $branch->id;
            $data['restaurant_id'] = $restaurant->id;

            $menu = Menu::create((new MenuDTO($data))->toArray());
            return [

                'header_code' => Response::HTTP_OK,
                'message'=> 'Menu Created',
                'body' => $menu
            ];
        }catch (Exception $e){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

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
            return [

                'header_code' => Response::HTTP_OK,
                'message'=> 'Menu Item Created',
                'body' => $menuItem
            ];
        }catch (Exception $e){
            DB::rollBack();
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

              }
    }



    public function updateMenu(int $menu_id, array $data): array
    {
        try {
            $menu = Menu::findOrFail($menu_id);
            $menu->update($data);
            return [

                'header_code' => Response::HTTP_OK,
                'message'=> 'Menu Updated',
                'body' => $menu
            ];
        }catch (Exception $e){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

              }
    }

    public function updateMenuItem(int $menu_item_id, array $data): array
    {
        try {
            $menu_item = MenuItem::findOrFail($menu_item_id);
            $menu_item->update($data);
            return [

                'header_code' => Response::HTTP_OK,
                'message'=> 'Menu Item Updated',
                'body' => $menu_item
            ];
        }catch (Exception $e){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

              }
    }





    public function menuWithItemCount()
    {
        try{
        $restaurant = $this->getRestaurant();
        $menus = Menu::where('restaurant_id', $restaurant->id)
            ->withCount('menuItems')
            ->get();
            return [

                'header_code' => Response::HTTP_OK,
                'message'=> 'Menu With Item Count',
                'body' => $menus
            ];
        }catch (Exception $e){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

              }
    }

    public function getChoicesWithMenuItem($menu_item_id)
    {
        try {

            $menu_item=MenuItem::where('id',$menu_item_id)
                ->with(['AssignedChoiceGroups.choiceGroup.choices'])->get(); // Assuming 'choiceGroups' and 'choiceItems' relationships exist
            $data = MenuWithMenuItemResource::collection($menu_item);
            return [

                'header_code' => Response::HTTP_OK,
                'message'=> 'Menu with menu items with choices',
                'body' => $data
            ];
        }catch (Exception $e){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

              }
    }
}
