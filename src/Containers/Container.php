<?php

namespace Ecommerce\Common\Containers;

interface Container
{
    public static function fromArray(array $data): Container;
}