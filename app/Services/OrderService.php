<?php

namespace App\Services;

use App\Models\Product;

class OrderService
{

    public function calculateTotal($orderId = null, $orderItems = null)
    {
        $total = 0;

        $orderId ? $products = $this->query($orderId)->get() : $products = $orderItems;

        if ($products) {
            foreach ($products as $product) {
                $total += (Product::find($product['product_id'])->price * $product['quantity']);
            }
        }

        return $total;

    }

    private function query($orderId)
    {
        $orderProducts = Orders_products::where('order_id', $orderId);
        return $orderProducts;

    }

}