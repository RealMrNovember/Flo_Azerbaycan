<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use App\Models\Category;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class CategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

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
                    ]),

                Section::make('Structure')
                    ->columns(12)
                    ->schema([
                        Select::make('parent_id')
                            ->label('Parent')
                            ->options(fn () => Category::query()->whereNull('parent_id')->orderBy('sort_order')->pluck('name->en', 'id')->all())
                            ->searchable()
                            ->preload()
                            ->columnSpan(6),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(180)
                            ->columnSpan(6),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(4),

                        Toggle::make('is_active')
                            ->inline(false)
                            ->default(true)
                            ->columnSpan(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_default')->label('Category')->searchable()->sortable(),
                TextColumn::make('slug')->sortable(),
                TextColumn::make('parent.name_default')->label('Parent')->sortable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
                TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
