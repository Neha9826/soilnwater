<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\FileUpload; 
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

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
                
                Forms\Components\Select::make('status')
                    ->options([
                        'Upcoming' => 'Upcoming Launch',
                        'Under Construction' => 'Under Construction',
                        'Ready to Move' => 'Ready to Move',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('rera_id')->label('RERA Registration ID'),
                Forms\Components\DatePicker::make('completion_date'),

                Forms\Components\TextInput::make('location')->required(),
                Forms\Components\TextInput::make('city')->default('Dehradun'),

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

                Forms\Components\FileUpload::make('images')
                    ->multiple()
                    ->directory('projects')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')->columnSpanFull(),
                Forms\Components\Toggle::make('is_featured'),
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
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rera_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('completion_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
