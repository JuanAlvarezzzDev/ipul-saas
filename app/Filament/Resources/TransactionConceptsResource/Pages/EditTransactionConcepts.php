<?php

namespace App\Filament\Resources\TransactionConceptsResource\Pages;

use App\Filament\Resources\TransactionConceptsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionConcepts extends EditRecord
{
    protected static string $resource = TransactionConceptsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
