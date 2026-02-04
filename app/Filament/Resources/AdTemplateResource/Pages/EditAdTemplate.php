<?php

namespace App\Filament\Resources\AdTemplateResource\Pages;

use App\Filament\Resources\AdTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdTemplate extends EditRecord
{
    protected static string $resource = AdTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
