<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{

    public function viewRestaurantById(){
        // return restaurant with menu with menu items with variations with variation array of size and every thing in table
        // basically do join like this restaurant->menu->menu_items->variations and addons
        // send response in data array in proper format. like
        /**
         * {restaurant_id: 1,
         * restaurant_name:,
         *  opening_time:,
         * closing_time:,
         * address:,
         * rating: 5 stars,
         * menus :{
         *     menu_id:1,
         *      menu_items:[
         *                  {item_id: 1,
         *                   name: burger,
         *                   price: 200, // if variations are empty then send []
         *                   variations:[
         *                               {
         *                                   id:1,
         *                                   name:choose your size,
         *                                   options:[
         *                                           {"size":"medium", "price":500"},
                                                        {"size":"small", "price":100"},
 *                                                      {"size":"large", "price":100"},
         *                                           ]
         *                               }
         *                               ],
         *                  addons:[
         *                          {id:,
         *                           options:
         *                                  [
         *                                                  {"mayo":500"},
*                                                              {"extra cheese":100"},
         *                                                       {"burger sauce":0},
         *                                  ]
         *                            }
         *                           ]
         *                                 }
         *
         *                   ]
         *               }
         *               }
         *  ask ali for any confusion in format or how to get these fields??
         */
    }
    public function deleteRestaurantById(){
// soft delete the restaurant
    }
    public function restoreRestaurantById(){
    /// restore the restaurant
    }
    public function updateRestaurantById(){
        // can update name, branch address, opening time closing time , logo path
    }

}
