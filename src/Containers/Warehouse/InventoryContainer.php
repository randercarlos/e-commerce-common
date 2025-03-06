<?php

namespace Ecommerce\Common\Containers\Warehouse;

use Ecommerce\Common\Containers\Container;

class InventoryContainer implements Container
{
    public function __construct(
        public int $productId,
        public float $quantity
    ) {
    }

    /**
     * @param array{productId: int, quantity: float} $data
     */
    public static function fromArray(array $data): InventoryContainer
    {
        return new static(
            $data['productId'],
            $data['quantity'],
        );
    }
}