<?php

namespace App\Filament\Resources\UserAdResource\Pages;

use App\Filament\Resources\UserAdResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserAd extends CreateRecord
{
    protected static string $resource = UserAdResource::class;
}
