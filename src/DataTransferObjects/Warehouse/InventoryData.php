<?php

namespace Ecommerce\Common\DataTransferObjects\Warehouse;

class InventoryData
{
    public int $productId;
    public float $quantity;

    public function __construct(
        int $productId,
        float $quantity,
    ) {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    /**
     * @param array{productId: int, quantity: float} $data
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['productId'],
            $data['quantity'],
        );
    }
}
