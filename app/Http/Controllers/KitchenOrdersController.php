<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;

class KitchenOrdersController extends Controller
{
    public function index(Request $request)
    {
        $pendingOrders = Order::with(['menuEntry', 'table'])
                        ->where('status', OrderStatus::Pending)
                        ->get();

        if($request->wantsJson()){
            return $pendingOrders;
        }

        return view('kitchen.index', [
            'pendingOrders' => $pendingOrders,

            'preparingOrders' => Order::with(['menuEntry', 'table'])
                        ->where('status', OrderStatus::Preparing)
                        ->get(),

            'completedOrders' => Order::with(['menuEntry', 'table'])
                        ->where('status', OrderStatus::Completed)
                        ->get(),
        ]);
    }
}
