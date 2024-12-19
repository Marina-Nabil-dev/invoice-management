<?php

namespace App\Models;

use App\Enums\InvoiceStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends BaseModel
{
    use LogsActivity;


    protected function casts()
    {
        return [
            'invoice_date' => 'date',
            'status' => InvoiceStatusEnum::class,
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function getActivitylogOptions(): LogOptions
    {

        return LogOptions::defaults()
            ->useLogName('invoice')
            ->logOnly(['invoice_number', 'customer_id', 'amount', 'status'])
            ->logOnlyDirty();
    }

    public function getRouteKey()
    {
        return 'invoice_number';
    }
}
