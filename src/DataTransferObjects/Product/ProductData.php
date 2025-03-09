<?php

namespace Ecommerce\Common\DataTransferObjects\Product;

class ProductData
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private CategoryData $category;

    public function __construct(
        int $id,
        string $name,
        string $description,
        float $price,
        CategoryData $category,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
    }

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
