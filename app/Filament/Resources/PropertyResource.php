<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
use Illuminate\Support\Str;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Collection;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    // Changed Icon to Building
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Real Estate';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- LEFT COLUMN (Content) ---
                Group::make()->schema([
                    
                    // 1. Title & Description
                    Section::make('Property Details')->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),

                    // 2. Media
                    Section::make('Media')->schema([
                        Forms\Components\FileUpload::make('images')
                            ->label('Property Images')
                            ->multiple()
                            ->reorderable()
                            ->directory('properties')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),

                    // 3. Specs & Price
                    Section::make('Specifications')->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('price')
                                ->label('Price')
                                ->required()
                                ->numeric()
                                ->prefix('₹'),

                            Forms\Components\Select::make('type')
                                ->options([
                                    'sale' => 'For Sale',
                                    'rent' => 'For Rent',
                                    'pg'   => 'PG / Hostel',
                                ])
                                ->required(),
                            
                            Forms\Components\TextInput::make('area_sqft')
                                ->label('Area (Sq Ft)')
                                ->numeric(),
                        ]),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('bedrooms')
                                ->numeric()
                                ->label('Beds'),

                            Forms\Components\TextInput::make('bathrooms')
                                ->numeric()
                                ->label('Baths'),

                            Forms\Components\Select::make('furnishing')
                                ->options([
                                    'furnished' => 'Fully Furnished',
                                    'semi-furnished' => 'Semi Furnished',
                                    'unfurnished' => 'Unfurnished',
                                ])
                                ->required(),
                        ]),
                    ]),

                ])->columnSpan(2),

                // --- RIGHT COLUMN (Sidebar) ---
                Group::make()->schema([
                    
                    // 1. Status & Visibility (Crucial for Admin)
                    Section::make('Status')->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Visible on Site')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Property'),

                        // THE NEW APPROVAL SWITCH
                        Forms\Components\Toggle::make('is_approved')
                            ->label('Admin Approved')
                            ->helperText('Required for public listing')
                            ->onColor('success')
                            ->offColor('danger'),
                    ]),

                    // 2. Location
                    Section::make('Location')->schema([
                        Forms\Components\TextInput::make('address')
                            ->required(),

                        Forms\Components\TextInput::make('city')
                            ->required()
                            ->default('Dehradun'),

                        Forms\Components\TextInput::make('state')
                            ->required()
                            ->default('Uttarakhand'),
                        
                        Forms\Components\TextInput::make('zip_code'),
                    ]),

                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Image
                Tables\Columns\ImageColumn::make('images')
                    ->circular()
                    ->stacked()
                    ->limit(1),

                // Title & Type
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Property $record): string => Str::limit($record->address, 30)),

                // Price
                Tables\Columns\TextColumn::make('price')
                    ->money('INR')
                    ->sortable()
                    ->weight('bold'),

                // Type Badge
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sale' => 'success',
                        'rent' => 'info',
                        'pg' => 'warning',
                        default => 'gray',
                    }),

                // Location
                Tables\Columns\TextColumn::make('city')
                    ->sortable(),

                // Status Toggles
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Visible'),

                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('Approved')
                    ->onColor('success')
                    ->offColor('danger'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Filter by Approval
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Approval Status')
                    ->trueLabel('Approved Only')
                    ->falseLabel('Pending Approval'),

                // Filter by Type
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'sale' => 'For Sale',
                        'rent' => 'For Rent',
                        'pg'   => 'PG',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Bulk Approve
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check')
                        ->action(fn (Collection $records) => $records->each->update(['is_approved' => true])),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}