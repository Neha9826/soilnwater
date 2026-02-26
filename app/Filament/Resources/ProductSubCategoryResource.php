<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductSubCategoryResource\Pages;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductSubCategoryResource extends Resource
{
    protected static ?string $model = ProductSubCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Shop Management'; // Kept together with Products

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Subcategory Details')
                    ->schema([
                        // 1. SELECT EXISTING CATEGORY
                        Forms\Components\Select::make('product_category_id')
                            ->label('Parent Category')
                            ->options(ProductCategory::where('is_approved', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Select the main category this subcategory belongs to.'),

                        // 2. SUBCATEGORY NAME
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ProductSubCategory::class, 'slug', ignoreRecord: true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                
                // Show the Parent Category in the table for clarity
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Parent Category')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductSubCategories::route('/'),
            'create' => Pages\CreateProductSubCategory::route('/create'),
            'edit' => Pages\EditProductSubCategory::route('/{record}/edit'),
        ];
    }
}