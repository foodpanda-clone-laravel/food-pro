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
    public function createVariationV2($data){
        // choice name
        // is required: true or false,
        // choice_type:
        // choices :[]
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

    // function for viewing all choice groups a restaurant has created,
    // restricted access to restaurant owner only
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
    }
    public function storeChoices(array $data)
    {
        $restaurant = $this->getRestaurant();
        $data['restaurant_id'] = $restaurant->id;
        if ($data['isChoice'] == 1) {
            // if it is compulsory add choices in choices
            $variation = Variation::create((new VariationDTO($data))->toArray());
            return response()->json([
                'success' => true,
                'message' => 'Variation saved successfully!',
                'data' => $variation,
            ]);
        } else {
            // if not add in addons
            $addOn = Addon::create((new AddonDTO($data))->toArray());
            return response()->json([
                'success' => true,
                'message' => 'Addon saved successfully!',
                'data' => $addOn,
            ]);
        }
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
