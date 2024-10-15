<?php

namespace App\Services\Menu;

use App\DTO\ChoiceGroupDTO;
use App\DTO\ChoiceItems;
use App\DTO\ChoiceItemsDTO;
use App\Interfaces\MenuServiceV2Interface;
use App\Models\Menu\AssignedChoiceGroup;
use App\Models\Menu\Choice;
use App\Models\Menu\ChoiceGroup;
use App\Models\Menu\Menu;
use Illuminate\Support\Facades\DB;

class MenuServiceV2 extends MenuBaseService implements MenuServiceV2Interface
{

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


    public function addChoiceGroup($data){
        $restaurant = MenuBaseService::getRestaurant();
        $data['restaurant_id']=$restaurant->id;
        $choiceGroupDTO = new ChoiceGroupDTO($data);
        $choiceGroup= ChoiceGroup::create($choiceGroupDTO->toArray());
        return $choiceGroup;
    }
    public function createVariation($data){
        // choice name
        // is required: true or false,
        // choice_type:
        // choices :[]
        try{
            DB::beginTransaction();
            $choiceGroup = $this->addChoiceGroup($data);
            $data['choice_group_id']=$choiceGroup->id;
            // if variation is required or not ?
            $choices = json_decode($data['choice_items'], true);
            foreach($choices as $choice){
                $choice['choice_group_id']=$choiceGroup->id;
                $choice['choice_type']=$data['choice_type'];
                    $choiceItemDTO = new ChoiceItemsDTO($choice);
                    $choiceItem = Choice::create($choiceItemDTO->toArray());
            }
            DB::commit();
            return true;
        }
        catch(\Exception $e){
            DB::rollBack();
            return false;
        }

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

    //is addtional ka
    /***
     * {
     *
     * choicename: 'Drink Sizes',
     *
     * ischoice: '0',
     * i will add is choice column to variations
     * if choice type is size add it to variations_v2
     *
     * choicetype: 'additional', if choice type is additional
     *
     * choiceitems: [{ name: 'Small', price: 1 }, { name: 'Medium', price: 1.5 }, { name: 'Large', price: 2 }, { name: 'Medium', price: 1.5 }, { name: 'Medium', price: 1.5 }, { name: 'Medium', price: 1.5 }],
     *
     * }
     */
}
