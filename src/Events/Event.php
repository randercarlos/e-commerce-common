<?php

namespace Ecommerce\Common\Events;

abstract class Event
{
    public function toJson(): string
    {
        return json_encode($this);
    }
}