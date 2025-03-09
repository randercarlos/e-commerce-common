<?php

namespace Ecommerce\Common\Events\Rating;

use Ecommerce\Common\DataTransferObjects\Rating\ProductRatingData;
use Ecommerce\Common\Enums\Events;
use Ecommerce\Common\Events\Event;

class ProductRatedEvent extends Event
{
    private ProductRatingData $data;

    public string $type = Events::PRODUCT_RATED;

    public function __construct(ProductRatingData $data)
    {
        $this->data = $data;
    }
}
