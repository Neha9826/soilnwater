<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserAdResource\Pages;
use App\Models\UserAd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class UserAdResource extends Resource
{
    protected static ?string $model = UserAd::class;
    protected static ?string $navigationLabel = 'My Customized Ads';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    // THE FORM: Where users edit their specific data
                    Forms\Components\Section::make('Customize This Ad')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Project Name')
                                ->live()
                                ->required(),

                            // Mapping to the JSON 'custom_data' column
                            Forms\Components\TextInput::make('custom_data.company_name')
                                ->label('Company Name')
                                ->live(),

                            Forms\Components\TextInput::make('custom_data.main_headline')
                                ->label('Headline')
                                ->live(),

                            Forms\Components\FileUpload::make('custom_data.image')
                                ->label('Custom Image')
                                ->image()
                                ->live(),
                        ])->columnSpan(2),

                    // THE PREVIEW: Where edits are reflected instantly
                    Forms\Components\Section::make('Live Preview')
                        ->schema([
                            Forms\Components\View::make('livewire.admin.ad-preview')
                                ->viewData([
                                    'get' => fn (Forms\Get $get) => $get,
                                ]),
                        ])->columnSpan(1),
                ])->columnSpanFull(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserAds::route('/'),
            'create' => Pages\CreateUserAd::route('/create'),
            'edit' => Pages\EditUserAd::route('/{record}/edit'),
        ];
    }
}