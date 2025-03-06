<?php

namespace Ecommerce\Common\Containers\Rating;

use Ecommerce\Common\Containers\Container;

class ProductRatingContainer implements Container
{
    public function __construct(
        public int $productId, 
        public int $rating, 
        public float $averageRating
    ) {
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