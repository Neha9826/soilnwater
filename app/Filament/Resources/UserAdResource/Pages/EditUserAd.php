<?php

namespace App\Filament\Resources\UserAdResource\Pages;

use App\Filament\Resources\UserAdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserAd extends EditRecord
{
    protected static string $resource = UserAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
