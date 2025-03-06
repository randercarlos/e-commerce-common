<?php

namespace Ecommerce\Common\Containers\Product;

use Ecommerce\Common\Containers\Container;

class ProductContainer implements Container
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public float $price,
        public CategoryContainer $category
    ) {
    }

    /**
     * @param array{id: int, name: string, description: string, price: float, category: array{
     *      id: int,
     *      name: string
     * }}
     */
    public static function fromArray(array $data): ProductContainer
    {
        return new static(
            $data['id'], 
            $data['name'], 
            $data['description'], 
            $data['price'],
            new CategoryContainer($data['category']['id'], $data['category']['name'])
        );
    }
}
