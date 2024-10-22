<?php

namespace App\GlobalVariables;

class PermissionVariables
{


    //Api.php Routes
    public static array $register = [
        'path' => '/register',
    ];
    public static array $registerBusiness = [
        'path' => '/register-business',
    ];

    public static array $session = [
        'path' => '/session',
    ];
    public static array $login = [
        'path' => '/login',
    ];
    public static array $logout = [
        'path' => '/logout',
    ];
    public static array $forgotPassword = [
        'path' => '/forgot-password',
    ];
    public static array $resetPassword = [
        'path' => '/reset-password',
    ];
    public static array $submitRestaurantRequest = [
        'path' => '/submit-restaurant-request',
    ];

    //restaurant.api Routes
    public static array $menuChoiceGroup = [
        'path' => 'menu/choice-group',
        'permission' => 'user can create menu item'
    ];
    public static array $menuAssignChoiceGroup = [
        'path' => 'menu/assign-choice-group',
        'permission' => 'user can create menu item'
    ];
    public static array $viewChoiceGroup = [
        'path' => '/choice-groups',
        'permission' => 'user can view menu'
    ];

    public static array $deleteChoiceGroup = [
        'path' => '/delete-choice-group',
        'permission' => 'user can remove menu item'
    ];
    public static array $updateChoiceGroup = [
        'path' => '/update-choice-group',
        'permission' => 'user can edit menu item'
    ];
    public static array $reviews = [
        'path' => '/my-reviews',
        'permission' => 'user can view ratings and feedback'
    ];

    public static array $revenue = [
        'path' => '/my-revenue',
        'permission' => 'user can view revenue report'
    ];

    public static array $restaurantRevenue = [
        'path' => '/restaurant-revenues',
        'permission' => 'user can view revenue report'
    ];

    public static array $viewRestaurant = [
        'path' => '/restaurant',
        'permission' => 'user can view restaurants'
    ];

    public static array $deactivateRestaurant = [
        'path' => '/deactivate-restaurant',
        'permission' => 'user can delete restaurant'
    ];

    public static array $updateRestaurant = [
        'path' => '/update-restaurant',
        'permission' => 'user can update restaurant'
    ];
    public static array $restoreRestaurant = [
        'path' => '/restore-restaurant',
        'permission' => 'user can restore restaurant'
    ];


    //Orders routes
    public static array $addToCart = [
        'path' => '/add-to-cart'
    ];

    public static array $viewCart = [
        'path' => '/cart'
    ];

    public static array $updateCart = [
        'path' => '/update-cart'
    ];

    public static array $cartItemsTotal = [
        'path' => '/cart-items-total'
    ];

    public static array $cartTotal = [
        'path' => '/total'
    ];

    public static array $viewRestaurantOrders = [
        'path' => '/restaurant/orders',
        'permission' => 'user can view order'


    ];
    public static array $updateOrderStatus = [
        'path' => '/orders/update-status',
        'permission' => 'user can update Order status'


    ];

    //Menu routes
    public static array $createMenu = [
        'path' => '/create/{branch_id}',
        'permission' => 'user can create menu item'


    ];

    public static array $addMenuItems = [
        'path' => 'add-item/{menu_id}',
        'permission' => 'user can create menu item'


    ];
    public static array $addAddOns = [
        'path' => '/add-addon/{menu_item_id}',
        'permission' => 'user can add add-ons'


    ];


    public static array $updateMenu = [
        'path' => '/update/{menu_item}',
        'permission' => 'user can edit menu item'


    ];
    public static array $updateMenuItem = [
        'path' => 'update-item/{menu_item_id}',
        'permission' => 'user can edit menu item'


    ];
    public static array $addChoice = [
        'path' => 'add-choice/{menu_id}',
        'permission' => 'user can add choice in menu'


    ];
    public static array $menuWithItemCount = [
        'path' => '/count',
        'permission' => 'user can view menu with menu count'



    ];
    public static array $updateChoice = [
        'path' => '/update-choice/{variation_id}',
        'permission' => 'user can update choice',


    ];

    public static array $menuWithMenuItem = [
        'path' => 'with-item/{menu_id}',
        'permission' => 'user can view menu',


    ];
    public static array $getChoicesWithMenuItem = [
        'path' => 'choices/{menu_item_id}',
        'permission' => 'user can view choices',


    ];
    public static array $deleteMenuItem = [
        'path' => 'delete-item/{menu_item_id}',
        'permission' => 'user can remove menu item',


    ];
    public static array $viewMenuItemById = [
        'path' => 'view-menu-item',
        'permission' => 'user can view menu item',


    ];


    //admins routes
    public static array $viewRestaurantApplications = [
        'path' => 'get-applications',
        'permission' => 'user can view application',


    ];
    public static array $acceptApplication = [
        'path' => 'accept-application/{request_id}',
        'permission' => 'user can manage application',


    ];
    public static array $rejectApplication = [
        'path' => 'reject-application/{request_id}',
        'permission' => 'user can manage application',


    ];
    public static array $updateApplication = [
        'path' => 'update-application/{request_id}',
        'permission' => 'user can manage application',


    ];
    public static array $viewAllOrders = [
        'path' => 'get-all-orders',
        'permission' => 'user can view all orders',


    ];
    public static array $viewOrderDetails = [
        'path' => 'order-details/{order_id}',
        'permission' => 'user can view order',


    ];
    public static array $viewDeactivatedRestaurants = [
        'path' => 'show-deactivated-restaurant',
        'permission' => 'user can view deactivated restaurant',


    ];
}
