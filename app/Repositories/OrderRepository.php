<?php

namespace App\Repositories;

use App\Models\Order;
use App\Interfaces\OrderRepositoryInterface;
 
class OrderRepository implements OrderRepositoryInterface 
{
    public function getAllOrders()
    {
        return Order::all();
    }
    public function getOrderById($OrderId)
    {

        return Order::findOrFail($OrderId);
    }
    public function getOrderByUserId($userId)
    {
        return Order::where('user_id',$userId);
    }


    public function deleteOrder($OrderId)
    {
        Order::destroy($OrderId);
    }

    public function createOrder(array $validated)
    {
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

        return $order;
    }
    public function updateOrder($OrderId, array $newDetails)
    {
        $Order =  Order::findOrFail($OrderId);
         $Order->update($newDetails);
         return $Order;
    }

    public function cancelOrder($orderId){

        $order =  Order::findOrFail($orderId);
        $order->update([
            'is_canceled' => 'true',
        ]);
        return $order;
       

    }
}