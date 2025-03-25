<?php
namespace App\Interfaces;

interface OrderRepositoryInterface 
{
    public function getAllOrders();
    public function getOrderById($OrderId);
    public function getOrderByUserId($userId);
    public function deleteOrder($OrderId);
    public function createOrder(array $OrderDetails);
    public function updateOrder($OrderId, array $newDetails);
    public function cancelOrder($OrderId);

}