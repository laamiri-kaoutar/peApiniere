<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plant;
use App\Models\OrderPlant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['orders' => Order::with('plants')->get()]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Order::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'plants' => 'required|array',
            'plants.*.id' => 'exists:plants,id',
            'plants.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'status' => 'pending',
            'user_id'=> auth()->id(),
            'total_amount' => 0, 
            'is_canceled' => false,
        ]);

        $totalAmount = 0;

        foreach ($validated['plants'] as $data) {

            $plant = Plant::find($data['id']);
            $quantity = $data['quantity'];
            $priceAtOrder = $plant->price * $quantity;
        
            OrderPlant::create([
                'order_id' => $order->id,
                'plant_id' => $plant->id,
                'quantity' => $quantity,
                'price_at_order' => $priceAtOrder,
            ]);
        
            $totalAmount += $priceAtOrder;
        }
        


        $order->update(['total_amount' => $totalAmount]);
        return response()->json(['message' => 'Order created successfully', 'order' => $order]);



    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json(['plant' => $order]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //  here i need to check if the update action if from an imployee 
        if ($request->user()->cannot('update', Order::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->is_canceled == true) {
            return response()->json(['message' => 'The Order already canceled', 'order' => $order]);
        }

        $validated=$request->validate([
            'status' => 'required|in:pending,preparing,delivered',
        ]);

       

        $order->update($validated);

        return response()->json(['message' => "Order updated to $order->status successfully", 'order' => $order]);
  
    }

    public function cancel( $orderId)
    {
        //  here i need to check if the update action if from an imployee 

        
        if ($request->user()->cannot('cancel', $order)) { 
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->is_canceled === true) {
            return response()->json(['message' => 'The Order already canceled', 'order' => $order]);
        }
        $order->update([
            'is_canceled' => 'true',
        ]);

        return response()->json(['message' => 'Order canceled successfully', 'order' => $order]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        OrderPlant::where('order_id', $order->id)->delete();

        $order->delete();
        return [ 
            'message'=> "The order deleted successfully"
        ];
    }

    public function getUserOrders()
    {
        auth()->id();
    }
}
