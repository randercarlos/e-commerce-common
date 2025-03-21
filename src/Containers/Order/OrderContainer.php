<?php

namespace Ecommerce\Common\Containers\Order;

use Ecommerce\Common\Containers\Container;
use JetBrains\PhpStorm\Pure;

class OrderContainer implements Container
{
    public int $productId;
    public float $quantity;
    public float $totalPrice;

    public function __construct(
        int $productId,
        float $quantity,
        float $totalPrice
    ) {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->totalPrice = $totalPrice;
    }

    /**
     * @param array{productId: int, quantity: float, totalPrice: float} $data
     * @return OrderContainer
     */
    #[Pure] public static function fromArray(array $data): OrderContainer
    {
        return new static(
            $data['productId'],
            $data['quantity'],
            $data['totalPrice']
        );
    }
}