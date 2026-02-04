<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdTierResource\Pages;
use App\Filament\Resources\AdTierResource\RelationManagers;
use App\Models\AdTier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdTierResource extends Resource
{
    protected static ?string $model = AdTier::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            // Card wrapper to make the form look like your other Filament resources
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Tier Name')
                    ->placeholder('e.g., Standard Square, Large Rectangle'),

                // Defining the Grid Units (1x1, 2x1, etc.)
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('grid_width')
                        ->numeric()
                        ->required()
                        ->default(1)
                        ->label('Width (Tiles)')
                        ->helperText('e.g., 1 for square, 2 for wide'),

                    Forms\Components\TextInput::make('grid_height')
                        ->numeric()
                        ->required()
                        ->default(1)
                        ->label('Height (Tiles)')
                        ->helperText('e.g., 1 for standard, 2 for tall'),

                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->prefix('₹')
                        ->required()
                        ->label('Price per Slot'),
                ]),

                Forms\Components\Toggle::make('is_free')
                    ->label('Mark as Free Advertisement'),
            ])
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('grid_width')->label('Width'),
            Tables\Columns\TextColumn::make('grid_height')->label('Height'),
            Tables\Columns\TextColumn::make('price')->money('inr')->label('Price'),
            Tables\Columns\IconColumn::make('is_free')->boolean()->label('Free'),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdTiers::route('/'),
            'create' => Pages\CreateAdTier::route('/create'),
            'edit' => Pages\EditAdTier::route('/{record}/edit'),
        ];
    }
}
