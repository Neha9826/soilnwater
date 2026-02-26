<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Shop Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // LEFT COLUMN (Main Content)
                Group::make()->schema([
                    
                    // 1. Basic Information
                    Section::make('Product Details')->schema([
                        Forms\Components\TextInput::make('name')
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
                    ])->columns(2),

                    // 2. Media (Images & Video)
                    Section::make('Media')->schema([
                        Forms\Components\FileUpload::make('images')
                            ->label('Product Gallery')
                            ->multiple()
                            ->reorderable()
                            ->directory('products')
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\FileUpload::make('video_path')
                                ->label('Upload Video (MP4)')
                                ->directory('product_videos')
                                ->acceptedFileTypes(['video/mp4', 'video/quicktime']),
                            
                            Forms\Components\TextInput::make('video_url')
                                ->label('Or YouTube Video URL')
                                ->placeholder('https://youtube.com/watch?v=...'),
                        ]),
                    ]),

                    // 3. Pricing & B2B
                    Section::make('Pricing & B2B')->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('price')
                                ->label('Base Price')
                                ->required()
                                ->numeric()
                                ->prefix('₹')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    $price = (float) $get('price');
                                    $discount = (float) $get('discount_percentage');
                                    $set('discounted_price', $price - ($price * ($discount / 100)));
                                }),

                            Forms\Components\TextInput::make('discount_percentage')
                                ->label('Discount %')
                                ->numeric()
                                ->default(0)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    $price = (float) $get('price');
                                    $discount = (float) $get('discount_percentage');
                                    $set('discounted_price', $price - ($price * ($discount / 100)));
                                }),

                            Forms\Components\TextInput::make('discounted_price')
                                ->label('Final Price')
                                ->numeric()
                                ->readOnly()
                                ->prefix('₹'),
                        ]),

                        // B2B REPEATER
                        Forms\Components\Repeater::make('tiered_pricing')
                            ->label('Bulk Quantity Pricing (B2B)')
                            ->schema([
                                Forms\Components\TextInput::make('min_qty')
                                    ->label('Min Qty')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('unit_price')
                                    ->label('Unit Price (₹)')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Add Wholesale Tier'),
                    ]),

                    // 4. Special Offers
                    // Section::make('Promotions')->schema([
                    //     Forms\Components\Toggle::make('has_special_offer')
                    //         ->label('Active Special Offer')
                    //         ->live(),
                        
                    //     Forms\Components\TextInput::make('special_offer_text')
                    //         ->label('Offer Details')
                    //         ->placeholder('e.g. Buy 2 Get 1 Free')
                    //         ->hidden(fn (Get $get) => !$get('has_special_offer')),
                    // ]),

                ])->columnSpan(2), // Takes up 2/3 of screen

                // RIGHT COLUMN (Sidebar)
                Group::make()->schema([
                    
                    // 1. Status & Visibility
                    Section::make('Status')->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Visible on site generally')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('is_sellable')
                            ->label('Online Sale')
                            ->helperText('Enable "Buy Now" button')
                            ->default(false),

                        Forms\Components\Toggle::make('is_approved')
                            ->label('Admin Approved')
                            ->helperText('Required for public listing')
                            ->onColor('success')
                            ->offColor('danger'),
                    ]),

                    // 2. Categorization
                    Section::make('Organization')->schema([
    Forms\Components\Select::make('product_category_id')
        ->label('Category')
        ->options(ProductCategory::all()->pluck('name', 'id'))
        ->reactive() // Enables sub-category filtering
        ->required(),

    Forms\Components\Select::make('product_sub_category_id')
        ->label('Sub Category')
        ->options(fn (Get $get) => ProductSubCategory::where('product_category_id', $get('product_category_id'))->pluck('name', 'id'))
        ->disabled(fn (Get $get) => !$get('product_category_id')) // Activation logic
        ->required(),
]),

                    // 3. Inventory & Shipping
                    Section::make('Inventory & Shipping')->schema([
                        Forms\Components\TextInput::make('stock_quantity')
                            ->label('Stock')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->default(fn () => strtoupper(Str::random(10))),

                        Forms\Components\TextInput::make('shipping_charges')
                            ->label('Shipping Cost (₹)')
                            ->numeric()
                            ->default(0),
                        
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('weight')->label('Weight (kg)'),
                            Forms\Components\TextInput::make('dimensions')->label('LxWxH (cm)'),
                        ]),
                    ]),

                ])->columnSpan(1), // Takes up 1/3 of screen

            ])->columns(3); // Total grid columns
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Image Thumbnail
                Tables\Columns\ImageColumn::make('images')
                    ->circular()
                    ->stacked()
                    ->limit(1),

                // Name & Brand
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Product $record): string => $record->brand ?? ''),

                // Price
                Tables\Columns\TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),

                // Stock
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->color(fn (string $state): string => $state < 10 ? 'danger' : 'success'),

                // Category (Fixed JSON Issue)
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                // Status Switches
                Tables\Columns\ToggleColumn::make('is_sellable')
                    ->label('For Sale'),

                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('Approved')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Filter: Pending Approval
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Approval Status')
                    ->placeholder('All Products')
                    ->trueLabel('Approved Only')
                    ->falseLabel('Pending Approval'),
                
                // Filter: Category
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Bulk Approve Action
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}