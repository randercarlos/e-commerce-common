<?php

namespace Ecommerce\Common\Enums;

abstract class Events
{
    const PRODUCT_CREATED = 'product:created:v1';
    const PRODUCT_RATED = 'product:rated:v1';

    const INVENTORY_UPDATED = 'inventory:updated:v1';

    const ORDER_CREATED = 'order:created:v1';
}