<?php

namespace App\Filament\Resources\AdTierResource\Pages;

use App\Filament\Resources\AdTierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdTier extends EditRecord
{
    protected static string $resource = AdTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
