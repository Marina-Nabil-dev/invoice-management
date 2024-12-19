<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Enums\InvoiceStatusEnum;
use App\Filament\Resources\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

protected function mutateFormDataBeforeCreate(array $data): array
{
    return [
      ...$data,
        'invoice_number' => rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999),
        'status' => InvoiceStatusEnum::Pending
    ];
}
}
