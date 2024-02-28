<?php

namespace src\Order\Domain\Contracts;

use src\Order\Domain\Order;
use src\Order\Domain\ValueObjects\OrderId;

interface OrderRepositoryContract
{
    public function find(OrderId $orderId): Order;

    public function save(Order $order): void;

    public function update(Order $order): void;

    public function delete(OrderId $orderId): void;
}
