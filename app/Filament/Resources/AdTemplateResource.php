<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdTemplateResource\Pages;
use App\Models\AdTemplate;
use Filament\Forms;
use Filament\Forms\Components\FileUpload; // Added for static previews
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdTemplateResource extends Resource
{
    protected static ?string $model = AdTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form {
        return $form->schema([
            // SECTION: Static Preview Image (The Robust Fix)
            Forms\Components\Section::make('Customer Grid Preview')
                ->description('Upload a static screenshot here to prevent design elements from overlapping in the selection grid.')
                ->schema([
                    FileUpload::make('preview_image')
                        ->label('Template Thumbnail')
                        ->image()
                        ->directory('template-previews')
                        ->visibility('public')
                        ->imageEditor()
                        ->helperText('This image will be shown to users in the "Select Design" step.'),
                ]),

            // SECTION: Live Master Preview (For Admin View)
            Forms\Components\Section::make('Template Master Preview')
                ->description('This is how the master design looks with your default content.')
                ->schema([
                    Forms\Components\Placeholder::make('preview')
                        ->label('')
                        ->content(function ($record) {
                            if (!$record) return "Save the template first to see the preview.";
                            
                            $previewData = $record->fields->mapWithKeys(function ($field) {
                                return [$field->field_name => $field->default_value];
                            })->toArray();

                            return new \Illuminate\Support\HtmlString(
                                view($record->blade_path, ['data' => $previewData])->render()
                            );
                        })
                ])->columnSpanFull(),

            // SECTION: Master Configuration
            Forms\Components\Section::make('Master Configuration')->schema([
                Forms\Components\Select::make('ad_tier_id')
                    ->relationship('tier', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Template Name (e.g. Beauty Square)'),
                Forms\Components\TextInput::make('blade_path')
                    ->required(),
            ])->columns(3),

            // SECTION: Dynamic Field Repeater
            Forms\Components\Section::make('Design the Master Preview')
                ->description('Admin: Fill these fields to set the default design data.')
                ->schema([
                    Forms\Components\Repeater::make('fields')
                        ->relationship('fields')
                        ->schema([
                            Forms\Components\TextInput::make('label')->required()->label('Field Label'),
                            Forms\Components\TextInput::make('field_name')->required()->label('DB Key'),
                            Forms\Components\Select::make('type')
                                ->options([
                                    'text' => 'Text', 
                                    'textarea' => 'Long Description', 
                                    'color' => 'Color', 
                                    'image' => 'Image'
                                ])
                                ->required(),
                            Forms\Components\Textarea::make('default_value')
                                ->label('Default Content')
                                ->placeholder('Admin: Enter default text or color hex here'),
                        ])->columns(4)
                ])
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('preview_image')
                    ->label('Preview')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('tier.name')
                    ->label('Ad Tier')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('blade_path')
                    ->label('Blade Path')
                    ->fontFamily('mono')
                    ->copyable()
                    ->color('gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ad_tier_id')
                    ->relationship('tier', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
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