<?php

namespace App\Filament\Resources\UserAdResource\Pages;

use App\Filament\Resources\UserAdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserAds extends ListRecords
{
    protected static string $resource = UserAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
