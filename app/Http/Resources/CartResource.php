<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        // Map Domain Product model values
        return [
            'cart' => [
                'id' => $this->id()->value(),
                'totalProducts' => $this->getTotalProducts(),
                'subtotal' => $this->getTotalPrice(),
                'totalPrice' => $this->getTotalPrice(),
                'items' => CartItemResource::collection($this->items())
            ]
        ];
    }
}
