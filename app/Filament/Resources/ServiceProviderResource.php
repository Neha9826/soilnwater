<?php

namespace App\Filament\Resources;

use App\Models\User;
use App\Filament\Resources\ServiceProviderResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ServiceProviderResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    
    // Change the menu name so it doesn't say "Users"
    protected static ?string $navigationLabel = 'Service Providers';
    protected static ?string $modelLabel = 'Service Provider';

    // CRITICAL: This ensures we ONLY see Service Providers in this list, not Admins or Buyers
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereIn('profile_type', ['service', 'consultant', 'builder']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section 1: Login Details
                Forms\Components\Section::make('Login Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Full Name'),
                            
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),
                            
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->hiddenOn('edit'), // Only ask for password when creating new
                    ])->columns(2),

                // Section 2: Microsite / Business Details
                Forms\Components\Section::make('Microsite & Business Details')
                    ->description('These details will appear on their Single Page Website.')
                    ->schema([
                        Forms\Components\TextInput::make('store_name')
                            ->label('Business / Name Display')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => 
                                $set('store_slug', \Illuminate\Support\Str::slug($state))
                            ),
                            
                        Forms\Components\TextInput::make('store_slug')
                            ->label('URL Slug (soilnwater.in/v/...)')
                            ->required()
                            ->unique(ignoreRecord: true),
                            
                        Forms\Components\Select::make('profile_type')
                            ->label('Provider Type')
                            ->options([
                                'service' => 'Home Service (Plumber, Cleaner)',
                                'consultant' => 'Consultant (Architect, Vastu)',
                                'builder' => 'Builder / Developer',
                            ])
                            ->required()
                            ->native(false),
                            
                        Forms\Components\Select::make('service_category')
                            ->label('Specific Category')
                            ->options([
                                // Services
                                'plumber' => 'Plumbing',
                                'electrician' => 'Electrician',
                                'cleaning' => 'Cleaning Service',
                                'repairs' => 'Appliance Repair',
                                // Consultants
                                'architect' => 'Architect',
                                'vastu' => 'Vastu Consultant',
                                'interior' => 'Interior Designer',
                                'legal' => 'Legal Consultant',
                                // Builder
                                'builder' => 'Real Estate Developer',
                            ])
                            ->required()
                            ->native(false),
                            
                        Forms\Components\TextInput::make('service_charge')
                            ->numeric()
                            ->prefix('₹')
                            ->label('Visiting Charge / Rate'),
                            
                        Forms\Components\Textarea::make('store_description')
                            ->label('About the Service')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('store_name')
                    ->label('Business Name')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('profile_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'consultant' => 'info',
                        'service' => 'success',
                        'builder' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('service_category')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListServiceProviders::route('/'),
            'create' => Pages\CreateServiceProvider::route('/create'),
            'edit' => Pages\EditServiceProvider::route('/{record}/edit'),
        ];
    }
}