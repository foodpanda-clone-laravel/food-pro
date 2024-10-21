<?php

namespace App\Http\Controllers\Customer;

use App\Services\Customer\CustomerService;
use App\Helpers\Helpers;
use App\Models\User\User;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CustomerRequests\UpdateProfileRequest;
use App\Http\Requests\CustomerRequests\UpdateCustomerAddressRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\DTO\CustomerDTO;

class ProfileController extends Controller
{
    protected $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function editProfile(UpdateProfileRequest $request)
    {
        $userId = auth()->user()->id;
        $validatedData = $request->getValidatedData();


        $this->customerService->updateProfile($userId, $validatedData);

        $updatedUser = User::with('customer')->find($userId);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Profile updated successfully', $updatedUser);
    }

    public function viewProfile()
    {
        $userId = auth()->user()->id;
        $customer = $this->customerService->getProfile($userId);

        return Helpers::sendSuccessResponse(
            Response::HTTP_OK,
            'Customer profile retrieved successfully',
            new ProfileResource($customer)
        );
    }

    public function updateCustomerAddress(UpdateCustomerAddressRequest $request)
    {
        $customerId = $request->get('customer_id');
        $validatedData = $request->getValidatedData();
        $isDefaultAddress = $request->routeIs('updateCustomerDefaultAddress');

        $data = [
            'user_id' => $customerId,
            'address' => $validatedData['address'] ?? null,
            'delivery_address' => $isDefaultAddress ? null : ($validatedData['delivery_address'] ?? null),
            'favorites' => $validatedData['favorites'] ?? null
        ];

        // Ensure either address or delivery_address is present
        if (is_null($data['address']) && is_null($data['delivery_address'])) {
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST, 'Either address or delivery address must be provided.');
        }

        $customerDTO = new CustomerDTO($data);

        $this->customerService->updateCustomerInfo($customerId, $customerDTO);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Customer address updated successfully');
    }


}
