<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set; // Added missing import
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str; // Added missing import
use Filament\Forms\Components\FileUpload;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Main Info')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Select::make('project_status')
                            ->options([
                                'Upcoming' => 'Upcoming',
                                'Ongoing' => 'Ongoing',
                                'Completed' => 'Completed',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('rera_number') // Corrected from rera_id
                            ->label('RERA Number'),

                        // Forms\Components\DatePicker::make('completion_date'),

                        Forms\Components\TextInput::make('price') // Corrected from starting_price
                            ->numeric()
                            ->prefix('₹'),
                    ])->columns(2),

                Forms\Components\Section::make('Location Details')
                    ->schema([
                        Forms\Components\TextInput::make('city')
                            ->required(),
                        Forms\Components\TextInput::make('state')
                            ->required(),
                        Forms\Components\TextInput::make('pincode')
                            ->numeric(),
                    ])->columns(3),

                Forms\Components\Section::make('Content & Gallery')
                    ->schema([
                        Forms\Components\CheckboxList::make('amenities')
                            ->options([
                                'club' => 'Club House',
                                'pool' => 'Swimming Pool',
                                'gym' => 'Gymnasium',
                                'park' => 'Jogging Park',
                                'security' => '24/7 Security',
                                'power' => 'Power Backup',
                            ])
                            ->columns(3)
                            ->columnSpanFull(),

                        FileUpload::make('images')
                            ->label('Project Gallery')
                            ->disk('public')
                            ->directory('projects/images')
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                        
                        Forms\Components\Toggle::make('is_featured'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(2),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('city') // Corrected: Database uses city, not location
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('rera_number') // Corrected from rera_id
                    ->label('RERA')
                    ->searchable(),

                Tables\Columns\TextColumn::make('project_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Upcoming' => 'gray',
                        'Ongoing' => 'warning',
                        'Completed' => 'success',
                    }),

                Tables\Columns\TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),

                // Tables\Columns\TextColumn::make('completion_date')
                //     ->date()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_status')
                    ->options([
                        'Upcoming' => 'Upcoming',
                        'Ongoing' => 'Ongoing',
                        'Completed' => 'Completed',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}