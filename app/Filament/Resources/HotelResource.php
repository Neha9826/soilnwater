<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResource\Pages;
use App\Filament\Resources\HotelResource\RelationManagers;
use App\Models\Hotel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => 
                        $set('slug', \Illuminate\Support\Str::slug($state))
                    ),

                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),

                Forms\Components\Select::make('type')
                    ->options([
                        'Hotel' => 'Hotel',
                        'Resort' => 'Resort',
                        'Homestay' => 'Homestay',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('star_rating')
                    ->numeric()
                    ->default(3)
                    ->maxValue(5)
                    ->minValue(1),

                Forms\Components\TextInput::make('price_per_night')
                    ->numeric()
                    ->prefix('₹')
                    ->required(),
                
                Forms\Components\TextInput::make('contact_phone')->tel()->required(),

                // Use a full width section for Amenities
                Forms\Components\CheckboxList::make('amenities')
                    ->options([
                        'wifi' => 'Free WiFi',
                        'pool' => 'Swimming Pool',
                        'ac' => 'Air Conditioning',
                        'parking' => 'Free Parking',
                        'restaurant' => 'Restaurant',
                        'gym' => 'Gym / Fitness',
                    ])
                    ->columns(3) // Show in 3 columns
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('images')
                    ->multiple()
                    ->directory('hotels')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')->columnSpanFull(),
                
                Forms\Components\TextInput::make('address')->columnSpanFull(),
                Forms\Components\TextInput::make('city')->default('Dehradun'),
                
                Forms\Components\Toggle::make('is_active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_per_night')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('star_rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact_phone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListHotels::route('/'),
            'create' => Pages\CreateHotel::route('/create'),
            'edit' => Pages\EditHotel::route('/{record}/edit'),
        ];
    }
}
