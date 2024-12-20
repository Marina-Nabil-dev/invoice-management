<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'invoice_number' => ['required'],
            'invoice_date' => ['required', 'date'],
            'amount' => ['required', 'numeric','min:0'],
            'description' => ['required'],
            'status' => ['required'],
            'customer_id' => ['required', 'exists:customers,id'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
