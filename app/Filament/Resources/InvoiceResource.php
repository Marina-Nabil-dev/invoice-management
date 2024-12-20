<?php

namespace App\Filament\Resources;

use App\Enums\InvoiceStatusEnum;
use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $slug = 'invoices';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Invoice Details')
                    ->columns()
                    ->schema([

                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->required(),

                        DatePicker::make('invoice_date'),

                        TextInput::make('amount')
                            ->mask(RawJs::make('$money($input)'))
                            ->numeric()
                            ->stripCharacters(',')
                            ->required()
                            ->numeric(),

                        TextInput::make('description')
                            ->required(),

                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->hiddenOn('create')
                            ->content(fn (?Invoice $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->hiddenOn('create')
                            ->content(fn (?Invoice $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')->copyable()->sortable()->searchable(),

                TextColumn::make('customer.name')
                    ->searchable(),

                TextColumn::make('invoice_date')
                    ->date(),

                TextColumn::make('amount')->money('EGP'),

                TextColumn::make('status')->badge()->color(fn(Invoice $invoice): string => InvoiceStatusEnum::colors($invoice->status->value))
                ->formatStateUsing(fn(Invoice $invoice): string => $invoice->status->prettifyName()),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                \Filament\Tables\Actions\ViewAction::make(),
                EditAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            \Filament\Infolists\Components\Section::make('Invoice Details')
                ->columns()
                ->schema([
                    TextEntry::make('invoice_number'),
                    TextEntry::make('customer.name'),
                    TextEntry::make('invoice_date'),
                    TextEntry::make('amount')->money('EGP'),
                    TextEntry::make('description'),
                    TextEntry::make('status')->badge()->color(fn(Invoice $invoice): string => InvoiceStatusEnum::colors($invoice->status->value))
                        ->formatStateUsing(fn(Invoice $invoice): string => $invoice->status->prettifyName()),
                ])
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
            'view' => Pages\ViewInvoice::route('/{record}'),
        ];
    }

}
