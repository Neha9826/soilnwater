<?php

namespace App\Filament\Resources\ProductSubCategoryResource\Pages;

use App\Filament\Resources\ProductSubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductSubCategories extends ListRecords
{
    protected static string $resource = ProductSubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
