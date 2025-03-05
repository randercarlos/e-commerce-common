<?php

namespace Ecommerce\Common\DataTransferObjects\Rating;

class ProductRatingData
{
    public function __construct(
        public readonly int $productId,
        public readonly int $rating,
        public readonly float $averageRating,
    ) {}

    /**
     * @param array{productId: int, rating: int, averageRating: float} $data
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['productId'],
            $data['rating'],
            $data['averageRating'],
        );
    }
}
