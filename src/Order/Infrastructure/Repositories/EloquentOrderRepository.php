<?php

namespace src\Order\Infrastructure\Repositories;

use App\Models\Order as EloquentOrderModel;
use src\Order\Domain\Contracts\OrderRepositoryContract;
use src\Order\Domain\Order;
use src\Order\Domain\ValueObjects\OrderId;
use src\Cart\Domain\ValueObjects\CartId;

class EloquentOrderRepository implements OrderRepositoryContract
{
    private EloquentOrderModel $eloquentOrderModel;

    public function __construct()
    {
        $this->eloquentOrderModel = new EloquentOrderModel;
    }

    public function find(OrderId $orderId): Order
    {
       //TODO implementar persistencia find
    }

    public function save(Order $order): void
    {
        $newOrder = $this->eloquentOrderModel->create([
            'id' => $order->id()->value(),
            'state' => $order->state()->value(),
            'price' => $order->price()->value()
        ]);

        $newOrder->items()->createMany(
            collect($order->items())
                ->map(function ($item) use ($order) { /** @var $item \src\Order\Domain\OrderItem */
                    return [
                        'id' => $item->id()->value(),
                        'order_id' => $order->id()->value(),
                        'product_id' => $item->product()->id()->value(),
                        'quantity' => $item->quantity()->value()
                    ];
                })
                ->toArray()
        );

        $newOrder->save();
    }

    public function update(Order $order): void
    {
        //TODO implementar persistencia update
    }

    public function delete(OrderId $orderId): void
    {
       //TODO implementar persistencia delete
    }

}
