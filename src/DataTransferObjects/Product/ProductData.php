<?php

namespace Ecommerce\Common\DataTransferObjects\Product;

class ProductData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly float $price,
        public readonly CategoryData $category,
    ) {}

    /**
     * @param array{id: int, name: string, description: string, price: float, category: array{
     *      id: int,
     *      name: string
     * }} $data
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['id'],
            $data['name'],
            $data['description'],
            $data['price'],
            new CategoryData($data['category']['id'], $data['category']['name'])
        );
    }
}
