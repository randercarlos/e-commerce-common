<?php

namespace Ecommerce\Common\DataTransferObjects\Product;

class CategoryData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ) {}

    /**
     * @param array{id: int, name: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new static($data['id'], $data['name']);
    }
}
