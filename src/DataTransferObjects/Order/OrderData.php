<?php

namespace Ecommerce\Common\DataTransferObjects\Order;

class OrderData
{
    private int $productId;
    private float $quantity;
    private float $totalPrice;

    public function __construct(
        int $productId,
        float $quantity,
        float $totalPrice,
    ) {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->totalPrice = $totalPrice;
    }

    /**
     * @param array{productId: int, quantity: float, totalPrice: float} $data
     * @return OrderData
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['productId'],
            $data['quantity'],
            $data['totalPrice'],
        );
    }
}
