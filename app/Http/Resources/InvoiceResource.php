<?php

namespace App\Http\Resources;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

/** @mixin Invoice */
class InvoiceResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'invoice_date' => $this->invoice_date->diffForHumans(),
            'amount' => Number::currency($this->amount, 'EGP'),
            'description' => $this->description,
            'status' => $this->status,

            'customer_name' => $this->customer->name,
        ];
    }
}
