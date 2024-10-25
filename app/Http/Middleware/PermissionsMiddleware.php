<?php

namespace App\Http\Middleware;

use App\GlobalVariables\PermissionVariables;
use App\Helpers\Helpers;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $authUser = Auth::user();
        if (!$authUser) {
            return Helpers:: sendFailureResponse( 403, 'Unauthorized user', []);
              }
        $authUserPermissions = $authUser->getAllPermissions()->pluck('name')->toArray();
        $path = str_replace('api', '', $request->path());

        $allPermissionVariables = [
            PermissionVariables::$register,
            PermissionVariables::$registerBusiness,
            PermissionVariables::$session,
            PermissionVariables::$login,
            PermissionVariables::$logout,
            PermissionVariables::$forgotPassword,
            PermissionVariables::$resetPassword,
            PermissionVariables::$submitRestaurantRequest,

            //restaurants.api routes
          //  PermissionVariables::$showRestaurantDetails,
            PermissionVariables::$menuChoiceGroup,
            PermissionVariables::$menuAssignChoiceGroup,
            PermissionVariables::$viewChoiceGroup,
            PermissionVariables::$deleteChoiceGroup,
            PermissionVariables::$updateChoiceGroup,
            PermissionVariables::$reviews,
            PermissionVariables::$revenue,
            PermissionVariables::$restaurantRevenue,
            PermissionVariables::$viewRestaurant,
            PermissionVariables::$deactivateRestaurant,
            PermissionVariables::$updateRestaurantDetails,
            PermissionVariables::$restoreRestaurant,
            PermissionVariables::$addToCart,
            PermissionVariables::$viewCart,
            PermissionVariables::$updateCart,
            PermissionVariables::$cartItemsTotal,
            PermissionVariables::$cartTotal,
            PermissionVariables::$viewRestaurantOrders,
            PermissionVariables::$updateOrderStatus,

            //menu routes
            PermissionVariables::$createMenu,
            PermissionVariables::$addMenuItems,
            PermissionVariables::$addAddOns,
            PermissionVariables::$updateMenu,
            PermissionVariables::$updateMenuItem,
            PermissionVariables::$addChoice,
            PermissionVariables::$menuWithItemCount,
            PermissionVariables::$updateChoice,
            PermissionVariables::$menuWithMenuItem,
            PermissionVariables::$getChoicesWithMenuItem,
            PermissionVariables::$deleteMenuItem,
            PermissionVariables::$viewMenuItemById,


            //admin routes
            PermissionVariables::$viewRestaurantApplications,
            PermissionVariables::$acceptApplication,
            PermissionVariables::$rejectApplication,
            PermissionVariables::$updateApplication,
            PermissionVariables::$viewAllOrders,
            PermissionVariables::$viewOrderDetails,
            PermissionVariables::$viewDeactivatedRestaurants,
            //public customer routes
            PermissionVariables::$searchRestaurant,
            PermissionVariables::$viewAllRestaurants,
            PermissionVariables::$viewMenus,
            PermissionVariables::$viewDeals,

            //private cutomer routes
            PermissionVariables::$favoriteItems,
            PermissionVariables::$viewRewards,
            PermissionVariables::$usePointsAtCheckout,
            PermissionVariables::$addFavoriteRestaurant,
            PermissionVariables::$removeFavoriteRestaurant,
            PermissionVariables::$editProfile,
            PermissionVariables::$updateCustomerAddress,
            PermissionVariables::$viewProfile,
            PermissionVariables::$myOrderHistory,
            PermissionVariables::$activeOrder,
            PermissionVariables::$viewCustomerOrderDetails,
            PermissionVariables::$submitFeedback,
        ];


        foreach ($allPermissionVariables as $permissionArray) {
            if ($permissionArray['path'] === $path) {
                if (!in_array($permissionArray['permission'], $authUserPermissions)) {
                    return Helpers::sendFailureResponse(Response::HTTP_FORBIDDEN, __FUNCTION__);
                }
            }
        }

        return $next($request);
    }
}
