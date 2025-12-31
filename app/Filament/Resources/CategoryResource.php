<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Settings'; // Optional: Groups it in sidebar

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                Select::make('type')
                    ->options([
                        'vendor' => 'Vendor',
                        'consultant' => 'Consultant',
                        'hotel' => 'Hotel/Resort',
                        'builder' => 'Builder',
                        'service' => 'Service Provider',
                    ])
                    ->required(),

                Toggle::make('is_active')
                    ->label('Approved / Active')
                    ->default(true)
                    ->helperText('If off, this category will not appear in the public dropdown.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                // Badge to show which User Type this belongs to
                TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'vendor',
                        'warning' => 'consultant',
                        'success' => 'service',
                        'danger' => 'hotel',
                        'gray' => 'builder',
                    ])
                    ->sortable(),

                // Instant Toggle to Approve/Reject directly from the table
                ToggleColumn::make('is_active')
                    ->label('Approved')
                    ->onColor('success')
                    ->offColor('danger'),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created On'),
            ])
            ->filters([
                // Filter by Type (e.g., Show only Vendor categories)
                SelectFilter::make('type')
                    ->options([
                        'vendor' => 'Vendor',
                        'consultant' => 'Consultant',
                        'hotel' => 'Hotel/Resort',
                        'builder' => 'Builder',
                        'service' => 'Service Provider',
                    ]),
            ])
            ->defaultSort('created_at', 'desc'); // Show newest (pending) first
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}