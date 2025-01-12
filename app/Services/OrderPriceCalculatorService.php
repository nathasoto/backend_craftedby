<?php
namespace App\Services;
use App\Models\Order;
class OrderPriceCalculatorService
{
    /**
     * Calculate the total price of an order based on its products and quantities.
     *
     * @param Order $order
     * @return float
     */
    public function calculateTotal(Order $order)
    {
        $total = 0;

        // Loop through each product in the order
        foreach ($order->products as $product) {
            $total += $product->pivot->quantity * $product->pivot->unit_price;
        }

        // Return the total price
        return $total;
    }
}
