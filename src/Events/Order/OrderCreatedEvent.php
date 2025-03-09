<?php

namespace Ecommerce\Common\Events\Order;

use Ecommerce\Common\DataTransferObjects\Order\OrderData;
use Ecommerce\Common\Enums\Events;
use Ecommerce\Common\Events\Event;

class OrderCreatedEvent extends Event
{
    public string $type = Events::ORDER_CREATED;

    public OrderData $orderData;

    public function __construct(OrderData $data)
    {
        $this->orderData = $data;
    }
}
