<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
class OrderController extends Controller
{
    private $orderService;
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }
    public function createOrder(){
        $this->orderService->createOrder();
    }
    public function updateOrder(){

    }
    

}
