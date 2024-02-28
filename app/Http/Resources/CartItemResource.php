<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'id' => $this->id()->value(),
            'priceTotal' => $this->getTotalPrice(),
            'quantity' => $this->quantity()->value(),
            'product' => [
                'id' => $this->product()->id()->value(),
                'name' => $this->product()->name()->value(),
                'price' => $this->product()->price()->value(),
                'image' => $this->product()->image()->value()
            ]
        ];
    }
}
