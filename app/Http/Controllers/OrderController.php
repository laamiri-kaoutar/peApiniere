<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Interfaces\OrderRepositoryInterface;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository) 
    {
        $this->middleware('auth:api');
        $this->orderRepository = $orderRepository;
    }

    /**
     * @OA\Get(
     *     path="/orders",
     *     summary="Get all orders",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of orders"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function index()
    {
        if (auth()->user()->cannot('viewAny', Order::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['orders' => $this->orderRepository->getAllOrders()]);
    }

    /**
     * @OA\Post(
     *     path="/orders",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"plants"},
     *             @OA\Property(
     *                 property="plants",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="quantity", type="integer", example=2)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Order created successfully"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
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

        $order = $this->orderRepository->createOrder($validated);

        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }

    /**
     * @OA\Get(
     *     path="/orders/{id}",
     *     summary="Get an order by ID",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Order ID"
     *     ),
     *     @OA\Response(response=200, description="Order details"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Order not found")
     * )
     */
    public function show($orderId)
    {
        $order = $this->orderRepository->getOrderById($orderId);

        if (auth()->user()->cannot('view', $order)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['order' => $order]);
    }

    /**
     * @OA\Put(
     *     path="/orders/{id}",
     *     summary="Update an order",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Order ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"pending", "preparing", "delivered"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Order updated successfully"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function update(Request $request, $orderId)
    {
        if ($request->user()->cannot('update', Order::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order = $this->orderRepository->getOrderById($orderId);

        if ($order->is_canceled) {
            return response()->json(['message' => 'The Order is already canceled', 'order' => $order]);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,preparing,delivered',
        ]);

        $order = $this->orderRepository->updateOrder($orderId, $validated);

        return response()->json(['message' => "Order updated to $order->status successfully", 'order' => $order]);
    }

    /**
     * @OA\Delete(
     *     path="/orders/{id}",
     *     summary="Delete an order",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Order ID"
     *     ),
     *     @OA\Response(response=200, description="Order deleted successfully"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function destroy($orderId)
    {
        if ($this->orderRepository->deleteOrder($orderId)) {
            return response()->json(['message' => "The order was deleted successfully"], 200);
        }
        return response()->json(['message' => "The order could not be deleted"], 400);
    }

    /**
     * @OA\Post(
     *     path="/orders/{id}/cancel",
     *     summary="Cancel an order",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Order ID"
     *     ),
     *     @OA\Response(response=200, description="Order canceled successfully"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function cancel($orderId)
    {
        $order = $this->orderRepository->getOrderById($orderId);

        if (auth()->user()->cannot('cancel', $order)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->status == "preparing" || $order->status == "delivered" || $order->is_canceled) {
            return response()->json(['message' => "The order is already $order->status or canceled", 'order' => $order]);
        }

        return response()->json(['message' => 'Order canceled successfully', 'order' => $this->orderRepository->cancelOrder($orderId)]);
    }

    /**
     * @OA\Get(
     *     path="/orders/user",
     *     summary="Get user's order history",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="User's order history"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function getUserOrders()
    {
        if (auth()->user()->cannot('getUserOrders', Order::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['message' => 'Your order history', 'orders' => $this->orderRepository->getOrderByUserId(auth()->id())]);
    }
}
