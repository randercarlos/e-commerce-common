<?php

namespace Ecommerce\Common\Events\Product;

use Ecommerce\Common\DataTransferObjects\Product\ProductData;
use Ecommerce\Common\Enums\Events;
use Ecommerce\Common\Events\Event;

class ProductCreatedEvent extends Event
{
    public string $type = Events::PRODUCT_CREATED;

    public ProductData $data;

    public function __construct(ProductData $data)
    {
        $this->data = $data;
    }
}
