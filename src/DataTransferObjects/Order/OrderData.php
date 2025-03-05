<?php

namespace Ecommerce\Common\DataTransferObjects\Order;

class OrderData
{
    public function __construct(
        public readonly int $productId,
        public readonly float $quantity,
        public readonly float $totalPrice,
    ) {}

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
