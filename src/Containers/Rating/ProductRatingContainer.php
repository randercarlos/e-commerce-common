<?php

namespace Ecommerce\Common\Containers\Rating;

use Ecommerce\Common\Containers\Container;

class ProductRatingContainer implements Container
{
    public int $productId;
    public int $rating;
    public float $averageRating;

    public function __construct(
        int $productId,
        int $rating,
        float $averageRating
    ) {
        $this->productId = $productId;
        $this->rating = $rating;
        $this->averageRating = $averageRating;
    }

    /**
     * @param array{productId: int, rating: int, averageRating: float} $data
     */
    public static function fromArray(array $data): ProductRatingContainer
    {
        return new static(
            $data['productId'],
            $data['rating'],
            $data['averageRating']
        );
    }
}