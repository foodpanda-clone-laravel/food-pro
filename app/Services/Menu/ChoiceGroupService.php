<?php

namespace App\Services\Menu;

use App\DTO\Menu\ChoiceGroupDTO;
use App\DTO\Menu\ChoiceItemsDTO;
use App\Interfaces\ChoiceGroupServiceInterface;
use App\Models\Menu\Addon;
use App\Models\Menu\AssignedChoiceGroup;
use App\Models\Menu\Choice;
use App\Models\Menu\ChoiceGroup;
use App\Models\Menu\MenuItem;
use Illuminate\Support\Facades\DB;

class ChoiceGroupService implements ChoiceGroupServiceInterface
{

    public function addChoiceGroup($data){
        $restaurant = MenuBaseService::getRestaurant();
        $data['restaurant_id']=$restaurant->id;
        $choiceGroupDTO = new ChoiceGroupDTO($data);
        $choiceGroup= ChoiceGroup::create($choiceGroupDTO->toArray());
        return $choiceGroup->toArray();
    }

    public function addChoiceItems($data, $choices){
        try{
            $choicesToInsert = [];
            foreach ($choices as $choice) {
                $choicesToInsert[] = [
                    'choice_group_id' => $data['id'],
                    'name' => $choice['name'],
                    'price' => $choice['price'],
                ];
            }
            $insertedChoices  =Choice::insert($choicesToInsert);
            return $insertedChoices;
        }
        catch(\Exception $e){
            return false;
        }
    }
    public function assignChoiceGroup($data){
        try{
            $restaurant = MenuBaseService::getRestaurant();
            return AssignedChoiceGroup::create($data);
        }
        catch(\Exception $e){
            return false;
        }
    }
    public function createChoiceGroupWithChoices($data){
        try{
            DB::beginTransaction();
            $restaurant = MenuBaseService::getRestaurant();
            $restaurantId = $restaurant->id;
            // get restaurant owner id and add choice group
            $choiceGroup = $this->addChoiceGroup($data);
            $data['choice_group_id']=$choiceGroup['id'];
            $choices = json_decode($data['choices'], true);
            foreach($choices as $choice){
                $choice['choice_group_id']=$choiceGroup['id'];
                $choice['choice_type']=$data['choice_type'];
                $choiceItemDTO = new ChoiceItemsDTO($choice);
                $choiceItem = Choice::create($choiceItemDTO->toArray());
            }
            DB::commit();
            return [$choiceGroup,$choices];
        }
        catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function getAllChoiceGroupsByRestaurant(){
        $restaurant = MenuBaseService::getRestaurant();
        return $restaurant->load(['choiceGroups.choices', 'choiceGroups.addons']);
    }
    public function deleteChoiceGroup($data){
        try{
            $choiceGroup = ChoiceGroup::where('id', $data['id']);
            $choiceGroup->delete();
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }

    public function updateChoiceGroup($data){
        try{
            DB::beginTransaction();
            $restaurant = MenuBaseService::getRestaurant();
            $data['restaurant_id']=$restaurant->id;
            // if $data['is_required']=0 which means choice group is not compulsory then they are added as addons
            $choiceGroup = ChoiceGroup::where('id', $data['id']);
            $storedChoices = $choiceGroup->choices;
            $userChoices = json_decode($data['choices'], true);
            $keyedUserChoices = array_column($userChoices, null, 'id');
            // if choice not present in db then insert it
            // if choice present in db but not in choices array delete it
            $storedChoicesIds = array_column($storedChoices->toArray(), 'id');
            $choicesToUpdateIds = array_column($userChoices, 'id');
            // use update or create
            $choiceGroupDTO = new ChoiceGroupDTO($data);
            $choiceGroup->update($choiceGroupDTO->toArray());
            foreach($storedChoicesIds as $id){
                $choice = Choice::where('id', $id)->first();
                if(in_array($id, $choicesToUpdateIds)){
                    // if choice is present in user input and database then  update it
                    $keyedUserChoices[$id]['choice_group_id']=$data['id'];
                    $updateChoiceDTO = new ChoiceItemsDTO($keyedUserChoices[$id]);
                    $choice->update($updateChoiceDTO->toArray());
                }
                else{
                    // if choice is not present in user input then delete from database
                    $choice->delete();
                }
            }
            // if user has entered new choices in input insert them in database
            if(isset($data['new_choices'])){
                $newChoices = json_decode($data['new_choices'],true);
                $newChoices = $this->addChoiceItems($data, $newChoices);
            }

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
        }
    }


}
