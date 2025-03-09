<?php

namespace Ecommerce\Common\Containers\Warehouse;

use Ecommerce\Common\Containers\Container;

class InventoryContainer implements Container
{
    public int $productId;
    public float $quantity;

    public function __construct(
        int $productId,
        float $quantity
    ) {
        $this->productId = $productId;
        $this->quantity = $quantity;
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