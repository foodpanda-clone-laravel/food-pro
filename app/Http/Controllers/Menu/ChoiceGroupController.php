<?php

namespace App\Http\Controllers\Menu;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest\AddChoiceGroupRequest;
use App\Http\Requests\MenuRequest\RequireChoiceGroupIdRequest;
use App\Http\Requests\MenuRequest\UpdateChoiceGroupRequest;
use App\Services\Menu\ChoiceGroupService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChoiceGroupController extends Controller
{
    protected $choiceGroupService;
    public function __construct(ChoiceGroupService $choiceGroupService)
    {
        $this->choiceGroupService = $choiceGroupService;
    }
    public function getAllChoiceGroups(){
        $result = $this->choiceGroupService->getAllChoiceGroupsByRestaurant();
        return Helpers::sendSuccessResponse(Response::HTTP_OK,'All choice Groups', $result);
    }

    public function createChoiceGroup(AddChoiceGroupRequest $request){
        $result  = $this->choiceGroupService->createChoiceGroupWithChoices($request);
        if(!$result){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        else{
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'created choice group successfully');

        }
    }
    public function updateChoiceGroup(UpdateChoiceGroupRequest $request){
        $result = $this->choiceGroupService->updateChoiceGroup($request);
        if(!$result){
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Updated choice group successfully', $result);
        }
        else{
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function deleteChoiceGroup(RequireChoiceGroupIdRequest $request){
        $result = $this->choiceGroupService->deleteChoiceGroup($request);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'deleted choice group successfully');
    }
    public function assignChoiceGroup(Request $request){
        $result = $this->choiceGroupService->assignChoiceGroup($request);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'assigned choice group successfully', $result);
    }

    public function getChoiceGroupById(Request $request){
        $result = $this->choiceGroupService->getChoiceGroupById($request->id);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Choice group details', $result);
    }




}
