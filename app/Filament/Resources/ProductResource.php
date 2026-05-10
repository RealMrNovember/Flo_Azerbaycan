<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class ProductResource extends Resource
{
    use Translatable;

    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $recordTitleAttribute = 'name_default';

    public static function getTranslatableLocales(): array
    {
        return ['az', 'ru', 'en'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Content')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(160),
                        Textarea::make('description')
                            ->rows(6)
                            ->maxLength(2000),
                    ]),

                Section::make('Catalog')
                    ->columns(12)
                    ->schema([
                        Select::make('brand_id')
                            ->label('Brand')
                            ->options(fn () => Brand::query()->where('is_active', true)->orderBy('slug')->pluck('name->en', 'id')->all())
                            ->searchable()
                            ->preload()
                            ->columnSpan(4),

                        Select::make('categories')
                            ->label('Categories')
                            ->multiple()
                            ->relationship('categories', 'name_default', modifyQueryUsing: fn (Builder $q) => $q->where('is_active', true)->orderBy('sort_order'))
                            ->searchable()
                            ->preload()
                            ->columnSpan(8),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(180)
                            ->columnSpan(4),

                        Select::make('product_type')
                            ->options([
                                'sneaker' => 'Sneaker',
                                'running' => 'Running',
                                'training' => 'Training',
                                'boot' => 'Boot',
                                'outdoor' => 'Outdoor',
                                'sandal' => 'Sandal',
                                'slipper' => 'Slipper',
                            ])
                            ->required()
                            ->columnSpan(4),

                        Select::make('gender')
                            ->options([
                                'women' => 'Women',
                                'men' => 'Men',
                                'kids' => 'Kids',
                                'unisex' => 'Unisex',
                            ])
                            ->required()
                            ->columnSpan(2),

                        Toggle::make('is_active')
                            ->inline(false)
                            ->default(true)
                            ->columnSpan(2),
                    ]),

                Section::make('Media')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('product-gallery')
                            ->collection('product-gallery')
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->previewable(true),
                    ]),

                Section::make('Variants (Color SKU → Sizes)')
                    ->description('Her renk ayrı SKU; her SKU altında numara + stok yönetimi.')
                    ->schema([
                        Repeater::make('variants')
                            ->relationship()
                            ->defaultItems(1)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['sku'] ?? null)
                            ->schema([
                                TextInput::make('sku')
                                    ->required()
                                    ->maxLength(64),

                                TextInput::make('barcode')
                                    ->maxLength(128),

                                ColorPicker::make('color_hex')
                                    ->label('Color'),

                                SpatieMediaLibraryFileUpload::make('variant-images')
                                    ->collection('variant-images')
                                    ->multiple()
                                    ->reorderable()
                                    ->image()
                                    ->previewable(true),

                                Tabs::make('Variant locales')
                                    ->tabs([
                                        Tabs\Tab::make('AZ')
                                            ->schema([
                                                TextInput::make('color_name.az')->label('Color name')->maxLength(80),
                                            ]),
                                        Tabs\Tab::make('RU')
                                            ->schema([
                                                TextInput::make('color_name.ru')->label('Color name')->maxLength(80),
                                            ]),
                                        Tabs\Tab::make('EN')
                                            ->schema([
                                                TextInput::make('color_name.en')->label('Color name')->maxLength(80),
                                            ]),
                                    ]),

                                TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₼'),

                                TextInput::make('compare_at_price')
                                    ->numeric()
                                    ->prefix('₼'),

                                Toggle::make('is_active')
                                    ->inline(false)
                                    ->default(true),

                                Repeater::make('sizes')
                                    ->relationship()
                                    ->defaultItems(1)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['size_label'] ?? null)
                                    ->columns(12)
                                    ->schema([
                                        TextInput::make('size_label')
                                            ->required()
                                            ->maxLength(16)
                                            ->columnSpan(4),

                                        TextInput::make('size_value')
                                            ->numeric()
                                            ->columnSpan(3),

                                        TextInput::make('stock_total')
                                            ->numeric()
                                            ->minValue(0)
                                            ->default(0)
                                            ->columnSpan(3),

                                        Toggle::make('is_active')
                                            ->inline(false)
                                            ->default(true)
                                            ->columnSpan(2),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_default')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('brand.name_default')
                    ->label('Brand')
                    ->sortable(),
                TextColumn::make('product_type')
                    ->badge()
                    ->sortable(),
                TextColumn::make('gender')
                    ->badge()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
