<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Orders_products;
use App\Services\OrderService;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function viewOrders()
    {
        $orders = Order::with('products')->paginate(10, ['*'], 'orderpage');
        return response()->json([ 'success' => true, 'data' => $orders]);

    }

    /**
     * edit the specified resource.
     *
     * @param  int  $id
     * @param string $status
     * @return \Illuminate\Routing\Redirector
     */
    public function changeOrderStatus($id, $status)
    {
        $order = Order::find($id);

        if (!$order) { 
            return response()->json([ 'success' => false, 'message' => 'Order not found' ], 404); 
        }

        $validator = \Validator::make( ['status' => $status], ['status' => 'required|string|in:confirmed,pending,cancelled'] ); 
        
        if ($validator->fails()) { 
            return response()->json([ 'success' => false, 'errors' => $validator->errors() ], 422); 
        }

        $order->update(['status' => $status]);
        return response()->json([ 'success' => true, 'order' => $order, 'message' => 'Order status updated successfully' ], 200);

    }


    /**
     * Show details for the specified resource.
     *
     * @param  int  $id
     */
    public function viewOrderDetails($id)
    {
        $order = Order::with('products')->find($id);

        if (!$order) { 
            return response()->json([ 'success' => false, 'message' => 'Order not found' ], 404); 
        }

        return response()->json([ 'success' => true, 'order' => $order ], 200);     
    }



    public function createOrder(CreateOrderRequest $request) {

        if(!$request->orderItems || empty($request->orderItems)){
            return response()->json([ 'success' => false, 'message' => 'Order not created there is no order items yet' ], 400);
        }

        //Calculate order total
        $orderService = new OrderService();
        $this->total = $orderService->calculateTotal(null,$request->orderItems);

        // Create order 
        $order = new Order; 
        $order->user_id = auth()->id();
        $order->total = $this->total;
        $order->status = $request->status ?? 'pending';
        $order->save();

        // Attach products 
        foreach ($request->orderItems as $item) { 
            $orderProduct = new Orders_products; 
            $orderProduct->order_id = $order->id; 
            $orderProduct->product_id = $item['product_id']; 
            $orderProduct->quantity = $item['quantity']; 
            $orderProduct->price = Product::find($item['product_id'])->price; 
            $orderProduct->save(); 
        }

        $order->load('products');
        return response()->json([ 'success' => true, 'order' => $order, 'message' => 'Order created successfully' ], 201);

    }

    
    /**
     * delete the specified resource
     * @param  int  $id
     */
    public function destroy($id)
    {
        try{
            
            $order = Order::findOrFail($id);
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'order deleted successfully'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);

        }

    }

}