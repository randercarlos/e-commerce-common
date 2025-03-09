<?php

namespace Ecommerce\Common\Containers\Product;

use Ecommerce\Common\Containers\Container;

class CategoryContainer implements Container
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param array{id: int, name: string} $data
     */
    public static function fromArray(array $data): CategoryContainer
    {
        return new static($data['id'], $data['name']);
    }
}
