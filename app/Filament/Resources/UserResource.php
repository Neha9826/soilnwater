<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Vendor & User Verification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                // --- SECTION 1: ADMIN DECISION (The only editable part) ---
                Section::make('Verification & License Status')
                    ->description('Review the details below and approve or suspend the account.')
                    ->schema([
                        Toggle::make('is_vendor')
                            ->label('Approve License / Verify Account')
                            ->helperText('Switch ON to approve this Vendor/Consultant. Switch OFF to suspend.')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(false),

                        Select::make('profile_type')
                            ->label('Assigned Position')
                            ->options([
                                'vendor' => 'Vendor (Shop Owner)',
                                'consultant' => 'Consultant (Service Provider)',
                                'dealer' => 'Property Dealer',
                                'customer' => 'Customer',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                // --- SECTION 2: PERSONAL INFO (Read Only) ---
                Section::make('Personal Information')
                    ->description('Personal details provided by the user. Read-only mode.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->readOnly(), // LOCKED

                        TextInput::make('email')
                            ->email()
                            ->label('Email Address')
                            ->readOnly(), // LOCKED

                        // Only show password when creating a NEW user manually. 
                        // Hide it completely when editing an existing user.
                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->visible(fn (string $context): bool => $context === 'create'),
                    ])->columns(2),

                // --- SECTION 3: BUSINESS DOCUMENTS (Read Only) ---
                Section::make('Business & Document Review')
                    ->description('Verify the business details and attached documents.')
                    ->schema([
                        TextInput::make('store_name')
                            ->label('Business / Store Name')
                            ->readOnly(),

                        TextInput::make('service_category')
                            ->label('Service Category')
                            ->readOnly(),

                        // If you have document images, we display them here
                        // Using 'FileUpload' with 'downloadable' allows you to view/download docs
                        FileUpload::make('store_logo')
                            ->label('Store Logo / ID Proof')
                            ->disk('public')
                            ->directory('uploads')
                            ->visibility('public')
                            ->disabled() // User cannot change this
                            ->dehydrated(false), // Prevent re-saving/overwriting
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->copyable(),

                TextColumn::make('profile_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'vendor'      => 'warning',
                        'consultant'  => 'info',
                        'dealer'      => 'success',
                        'customer'    => 'gray',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                // Fast Toggle to Verify directly from the list
                Tables\Columns\ToggleColumn::make('is_vendor')
                    ->label('Verified?')
                    ->onColor('success')
                    ->offColor('danger'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('profile_type'),
                Tables\Filters\TernaryFilter::make('is_vendor')
                    ->label('Verification Status')
                    ->trueLabel('Verified Users')
                    ->falseLabel('Pending / Suspended'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Verify Details'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}