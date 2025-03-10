<?php

namespace Ecommerce\Common\DataTransferObjects\Product;

class CategoryData
{
    public int $id;
    public string $name;

    public function __construct(
        int $id,
        string $name,
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param array{id: int, name: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new static($data['id'], $data['name']);
    }
}
