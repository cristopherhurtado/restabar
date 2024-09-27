<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UpdateOrdersStatusController extends Controller
{
    public function update(Order $order, Request $request)
    {
        $order->update([
            'status' => $request->input('status'),
        ]);

        return $order->load(['menuEntry', 'table']);
    }
}
