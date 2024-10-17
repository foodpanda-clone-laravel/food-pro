<?php

namespace App\Services\Menu;

use App\DTO\AddonDTO;
use App\DTO\ChoiceGroupDTO;
use App\DTO\ChoiceItems;
use App\DTO\ChoiceItemsDTO;
use App\Interfaces\MenuServiceV2Interface;
use App\Models\Menu\Addon;
use App\Models\Menu\AssignedChoiceGroup;
use App\Models\Menu\Choice;
use App\Models\Menu\ChoiceGroup;
use App\Models\Menu\Menu;
use App\Models\Menu\MenuItem;
use Illuminate\Support\Facades\DB;

class MenuServiceV2 extends MenuBaseService implements MenuServiceV2Interface
{

//    public function createAddon(array $data, int $menu_item_id)
//    {
//        try {
//            // Find the menu item
//            $menu_item = MenuItem::findOrFail($menu_item_id);
//
//            $data['menu_item_id']=$menu_item->id;
//
//            $addOn = Addon::create((new AddonDTO($data))->toArray());
//
//            return ['success' => true, 'addon' => $addOn]; // Return the addon
//        } catch (Exception $e) {
//            return ['success' => false, 'error' => 'Unable to create addon'];
//        }
//    }


    public function addChoiceGroup($data){
        $restaurant = MenuBaseService::getRestaurant();
        $data['restaurant_id']=$restaurant->id;
        $choiceGroupDTO = new ChoiceGroupDTO($data);
        $choiceGroup= ChoiceGroup::create($choiceGroupDTO->toArray());
        return $choiceGroup->toArray();
    }
    public function createVariation($data){
        // choice name
        // is required: true or false,
        // choice_type:
        // choices :[]
        try{
            DB::beginTransaction();
            $choiceGroup = $this->addChoiceGroup($data);
            if($data['is_required']==0){
                // create addons
            }
            else{

            }
            $data['choice_group_id']=$choiceGroup['id'];

            $choices = json_decode($data['choices'], true);

            foreach($choices as $choice){
                $choice['choice_group_id']=$choiceGroup['id'];
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
    public function addChoiceItem($data, $choices){
    // I want the menu item to add in the choice group , here I need validation check
        try{

//            $choices = json_decode($choices, true);
            $choicesToInsert = [];

            foreach ($choices as $choice) {
                $choicesToInsert[] = [
                    'choice_group_id' => $data['id'],
                    'name' => $choice['name'],
                    'price' => $choice['price'],
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
    public function createVariationV2($data){

        try{
            $restaurant = MenuBaseService::getRestaurant();
            $restaurantId = $restaurant->id;

            DB::beginTransaction();

            $choiceGroup = $this->addChoiceGroup($data);
            $data['choice_group_id']=$choiceGroup['id'];
            $choices = json_decode($data['choices'], true);

            if($data['is_required']==0){
                foreach($choices as $choice){
                    $choice['choice_group_id']=$choiceGroup['id'];
                    $choice['restaurant_id']=$restaurantId;
//                    $choice['choice_type']=$data['choice_type'];  // needed for addon
                    $addonDTO = new AddonDTO($choice);
                    Addon::create($addonDTO->toArray());
                }
            }
            else{
                foreach($choices as $choice){
                    $choice['choice_group_id']=$choiceGroup['id'];
                    $choice['choice_type']=$data['choice_type'];
                    $choiceItemDTO = new ChoiceItemsDTO($choice);
                    $choiceItem = Choice::create($choiceItemDTO->toArray());
                }
            }
            DB::commit();
            return true;
        }
        catch(\Exception $e){
            dd($e);
            DB::rollBack();
            return false;
        }
    }
    public function getChoiceGroupById($id){
        return ChoiceGroup::where('id', $id)->first();
    }


    public function getAllChoiceGroupsByRestaurant(){
        $restaurant = MenuBaseService::getRestaurant();
        return $restaurant->load(['choiceGroups.choices', 'choiceGroups.addons']);
    }
    public function deleteChoiceGroup($data){
        try{

            $choiceGroup = ChoiceGroup::where('id', $data['id'])->firstOrFail();
            $choiceGroup->delete();
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }
    public function updateChoiceGroup($data){
        $restaurant = MenuBaseService::getRestaurant();
        $data['restaurant_id']=$restaurant->id;
        // if isrequired = 0 then we have addons as stored choices else choices
        $choiceGroup = ChoiceGroup::where('id', $data['id'])->firstOrFail();
        $storedChoices = $choiceGroup->choices;

        $userChoices = json_decode($data['choices'], true);
        $keyedUserChoices = array_column($userChoices, null, 'id');
        // if choice not present in db then insert it
        // if choice present in db but not in choices array delete it
        $storedChoicesIds = array_column($storedChoices->toArray(), 'id');
        $choicesToUpdateIds = array_column($userChoices, 'id');
        try{
            DB::beginTransaction();
            $choiceGroupDTO = new ChoiceGroupDTO($data);
            $choiceGroup->update($choiceGroupDTO->toArray());
            if($choiceGroup->is_required==0){

            }
            else{

            }
            if($choiceGroup->is_required==0){
                $storedChoices = $choiceGroup->addons;
                $storedChoicesIds = array_column($storedChoices->toArray(), 'id');
                $choicesToUpdateIds = array_column($userChoices, 'id');
                foreach($storedChoicesIds as $id){
                    $choice = Addon::where('id', $id)->first();
                    if(in_array($id, $choicesToUpdateIds)){ // if choice is present in db update it
                        $keyedUserChoices[$id]['choice_group_id']=$data['id'];
                        $keyedUserChoices[$id]['restaurant_id']=$data['restaurant_id'];
                        $updateChoiceDTO = new AddonDTO($keyedUserChoices[$id]);
                        $choice->update($updateChoiceDTO->toArray());
                    }
                    else{ // if choice is not pressent in db delete it
                        $choice->delete();
                    }
                }
                if(isset($data['new_choices'])){
                    $newChoices = json_decode($data['new_choices'],true);
                    $this->createAddon($newChoices, $choiceGroup->id, $data['restaurant_id']);
                }

            }
            else{
                foreach($storedChoicesIds as $id){
                    $choice = Choice::where('id', $id)->first();
                    if(in_array($id, $choicesToUpdateIds)){ // if choice is present in db update it
                        $keyedUserChoices[$id]['choice_group_id']=$data['id'];
                        $updateChoiceDTO = new ChoiceItemsDTO($keyedUserChoices[$id]);
                        $choice->update($updateChoiceDTO->toArray());
                    }
                    else{ // if choice is not pressent in db delete it
                        $choice->delete();
                    }
                }
                if(isset($data['new_choices'])){
                    $newChoices = json_decode($data['new_choices'],true);
                    $newChoices = $this->addChoiceItem($data, $newChoices);
                }

            }

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            dd($e);
        }


    }
    public function viewMenuItemById($id){
        $menuItem = MenuItem::where('id',$id)->firstOrFail();
        return $menuItem;
    }
    public function createAddon($data, $choiceGroupId, $restaurantId){
        foreach($data as $addon){
            $addon['choice_group_id']=$choiceGroupId;
            $addon['restaurant_id']=$restaurantId;
            $addonDto = new AddonDTO($addon);
            Addon::create($addonDto->toArray());
        }

    }
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
