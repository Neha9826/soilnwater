<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdTemplateResource\Pages;
use App\Filament\Resources\AdTemplateResource\RelationManagers;
use App\Models\AdTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdTemplateResource extends Resource
{
    protected static ?string $model = AdTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form {
    return $form->schema([
        Forms\Components\Section::make('Template Master Preview')
            ->description('This is how the master design looks with your default content.')
            ->schema([
                Forms\Components\Placeholder::make('preview')
                    ->label('')
                    ->content(function ($record) {
                        if (!$record) return "Save the template first to see the preview.";
                        
                        // Map the saved field defaults to a data array
                        $previewData = $record->fields->mapWithKeys(function ($field) {
                            return [$field->field_name => $field->default_value];
                        })->toArray();

                        // Render the actual blade file defined in 'blade_path'
                        return new \Illuminate\Support\HtmlString(
                            view($record->blade_path, ['data' => $previewData])->render()
                        );
                    })
            ])->columnSpanFull(),

        Forms\Components\Section::make('Master Configuration')->schema([
            Forms\Components\Select::make('ad_tier_id')->relationship('tier', 'name')->required(),
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('blade_path')->required(),
        ])->columns(3),

        Forms\Components\Section::make('Master Configuration')->schema([
            Forms\Components\Select::make('ad_tier_id')->relationship('tier', 'name')->required(),
            Forms\Components\TextInput::make('name')->required()->label('Template Name (e.g. Beauty Square)'),
            Forms\Components\TextInput::make('blade_path')->required(),
        ])->columns(3),

        Forms\Components\Section::make('Design the Master Preview')
            ->description('Admin: Fill these fields to set the default design data.')
            ->schema([
                Forms\Components\Repeater::make('fields')
                    ->relationship('fields')
                    ->schema([
                        Forms\Components\TextInput::make('label')->required()->label('Field Label'),
                        Forms\Components\TextInput::make('field_name')->required()->label('DB Key'),
                        Forms\Components\Select::make('type')
                            ->options(['text' => 'Text', 'textarea' => 'Long Description (Textarea)', 'color' => 'Color', 'image' => 'Image'])
                            ->required(),
                        // NEW: Admin fills this to create the Master design
                        Forms\Components\Textarea::make('default_value')
                            ->label('Default/Master Content')
                            ->placeholder('Admin: Enter default text or color hex here'),
                    ])->columns(4)
            ])
    ]);
}

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                // This shows the Name of the Template (Beauty, Grand Opening, etc.)
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // Shows which Tier the template belongs to
                Tables\Columns\TextColumn::make('tier.name')
                    ->label('Ad Tier')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                // Displays the Blade file path for quick verification
                Tables\Columns\TextColumn::make('blade_path')
                    ->label('Blade Path')
                    ->fontFamily('mono')
                    ->copyable()
                    ->color('gray'),

                // Shows the date it was added
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add a filter to sort by Tier if needed
                Tables\Filters\SelectFilter::make('ad_tier_id')
                    ->relationship('tier', 'name')
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdTemplates::route('/'),
            'create' => Pages\CreateAdTemplate::route('/create'),
            'edit' => Pages\EditAdTemplate::route('/{record}/edit'),
        ];
    }
}
