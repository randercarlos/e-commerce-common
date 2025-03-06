<?php

namespace Ecommerce\Common\Containers\Product;

use Ecommerce\Common\Containers\Container;

class CategoryContainer implements Container
{
    public function __construct(public int $id, public string $name)
    {
    }

    /**
     * @param array{id: int, name: string} $data
     */
    public static function fromArray(array $data): CategoryContainer
    {
        return new static($data['id'], $data['name']);
    }
}
