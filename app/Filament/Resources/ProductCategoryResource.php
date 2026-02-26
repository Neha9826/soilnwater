<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductCategoryResource\Pages;
use App\Filament\Resources\ProductCategoryResource\RelationManagers;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Shop Management'; // Matches ProductResource

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Main Category Setup')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                    
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ProductCategory::class, 'slug', ignoreRecord: true),

                    Forms\Components\TextInput::make('commission_percentage')
                        ->label('Commission (%)')
                        ->numeric()
                        ->default(0)
                        ->prefix('%'),

                    Forms\Components\Toggle::make('is_approved')
                        ->label('Approved')
                        ->default(true),
                ])->columns(2),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('commission_percentage')
                    ->label('Commission')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sub_categories_count')
                    ->label('Sub Categories')
                    ->counts('subCategories'), // Shows how many sub-cats exist
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
        ];
    }
}