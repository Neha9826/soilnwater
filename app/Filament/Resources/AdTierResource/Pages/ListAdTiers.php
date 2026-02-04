<?php

namespace App\Filament\Resources\AdTierResource\Pages;

use App\Filament\Resources\AdTierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdTiers extends ListRecords
{
    protected static string $resource = AdTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
