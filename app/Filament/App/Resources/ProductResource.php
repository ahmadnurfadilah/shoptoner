<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ProductResource\Pages;
use App\Filament\App\Resources\ProductResource\RelationManagers;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductType;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('name')->required(),
                                        RichEditor::make('description')->required(),
                                    ]),
                                Tabs::make('Tabs')
                                    ->tabs([
                                        Tabs\Tab::make('General')
                                            ->icon('heroicon-o-cog-6-tooth')
                                            ->schema([
                                                TextInput::make('price')
                                                    ->required()
                                                    ->numeric(),
                                                Grid::make(3)
                                                    ->schema([
                                                        Checkbox::make('downloadable')
                                                            ->live()
                                                            ->hintIcon('heroicon-o-information-circle')
                                                            ->hintIconTooltip('Downloadable products give access to a file upon purchase')
                                                    ]),
                                                Repeater::make('downloadable_files')
                                                    ->schema([
                                                        TextInput::make('name')->required(),
                                                        FileUpload::make('file')
                                                            ->required()
                                                            ->openable()
                                                            ->downloadable()
                                                            ->previewable(false)
                                                            ->disk('s3')
                                                            ->directory('product/downloadable')
                                                            ->visibility('public')
                                                            ->getUploadedFileUsing(static function (BaseFileUpload $component, string $file, string | array | null $storedFileNames): ?array {
                                                                /** @var FilesystemAdapter $storage */
                                                                $storage = $component->getDisk();
                                                                if (!$storage->exists($file)) {
                                                                    return null;
                                                                }
                                                                $url = config('app.cdn_url') . '/' . $file;
                                                                return [
                                                                    'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? basename($file),
                                                                    'size' => $storage->size($file),
                                                                    'type' => $storage->mimeType($file),
                                                                    'url' => $url,
                                                                ];
                                                            }),
                                                    ])
                                                    ->columns(2)
                                                    ->addActionLabel('Add more file')
                                                    ->hidden(fn (Get $get) => !$get('downloadable')),
                                            ]),
                                        Tabs\Tab::make('Inventory')
                                            ->icon('heroicon-o-circle-stack')
                                            ->schema([
                                                TextInput::make('sku')
                                                    ->label('SKU'),
                                                Checkbox::make('track_stock')
                                                    ->live()
                                                    ->label('Track stock quantity for this product'),
                                                TextInput::make('stock')
                                                    ->label('Stock quantity')
                                                    ->numeric()
                                                    ->hidden(fn (Get $get) => !$get('track_stock')),
                                            ]),
                                        Tabs\Tab::make('Attributes')
                                            ->icon('heroicon-o-queue-list')
                                            ->schema([
                                                Repeater::make('attributes')
                                                    ->schema([
                                                        Select::make('name')
                                                            ->live()
                                                            ->searchable()
                                                            ->options(ProductAttribute::where('store_id', Filament::getTenant()->id)->pluck('name', 'id'))
                                                            ->distinct(),
                                                        Select::make('values')
                                                            ->multiple()
                                                            ->options(function (Get $get) {
                                                                $attr = ProductAttribute::find($get('name'));
                                                                return $attr->terms ?? [];
                                                            })
                                                            ->columnSpan(2),
                                                    ])
                                                    ->defaultItems(0)
                                                    ->columns(3)
                                                    ->addActionLabel('Add more attribute'),
                                            ]),
                                        Tabs\Tab::make('Variations')
                                            ->icon('heroicon-o-squares-plus')
                                            ->hidden(fn (Get $get) => $get('type_id') == '1')
                                            ->schema([
                                                Placeholder::make('Only show when product type is Physical Product'),
                                            ]),
                                        Tabs\Tab::make('Shipping')
                                            ->icon('heroicon-o-truck')
                                            ->hidden(fn (Get $get) => $get('type_id') == '1')
                                            ->schema([
                                                Placeholder::make('Only show when product type is Physical Product'),
                                            ]),
                                    ])
                            ])
                            ->columnSpan(2),
                        Section::make()
                            ->schema([
                                Toggle::make('is_published')->label('Published'),
                                Select::make('type_id')
                                    ->label('Product Type')
                                    ->live()
                                    ->required()
                                    ->searchable()
                                    ->options(ProductType::pluck('name', 'id'))
                                    ->disableOptionWhen(fn (string $value): bool => $value == '2'),
                                Select::make('category_id')
                                    ->label('Product Category')
                                    ->required()
                                    ->relationship(name: 'category', titleAttribute: 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionAction(
                                        fn (Action $action) => $action->modalWidth('xl'),
                                    )
                                    ->createOptionForm([
                                        TextInput::make('name')->required(),
                                    ])
                                    ->createOptionUsing(function ($data) {
                                        ProductCategory::create([
                                            'store_id' => Filament::getTenant()->id,
                                            'name' => $data['name'],
                                        ]);
                                    }),
                                FileUpload::make('thumbnail')
                                    ->image()
                                    ->maxSize(512)
                                    ->disk('s3')
                                    ->directory('product/thumbnail')
                                    ->visibility('public')
                                    ->getUploadedFileUsing(static function (BaseFileUpload $component, string $file, string | array | null $storedFileNames): ?array {
                                        /** @var FilesystemAdapter $storage */
                                        $storage = $component->getDisk();
                                        if (!$storage->exists($file)) {
                                            return null;
                                        }
                                        $url = config('app.cdn_url') . '/' . $file;
                                        return [
                                            'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? basename($file),
                                            'size' => $storage->size($file),
                                            'type' => $storage->mimeType($file),
                                            'url' => $url,
                                        ];
                                    }),
                                FileUpload::make('gallery')
                                    ->image()
                                    ->maxSize(512)
                                    ->multiple()
                                    ->reorderable()
                                    ->appendFiles()
                                    ->openable()
                                    ->downloadable()
                                    ->previewable(false)
                                    ->disk('s3')
                                    ->directory('product/gallery')
                                    ->visibility('public'),
                            ])
                            ->columnSpan(1)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')->badge(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('sku')->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->numeric()
                    ->suffix(' TON'),
                Tables\Columns\TextColumn::make('stock')->default('Unlimited'),
            ])
            ->filters([
                SelectFilter::make('type_id')
                    ->label('Type')
                    ->searchable()
                    ->options(ProductType::pluck('name', 'id')),
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->searchable()
                    ->options(ProductCategory::where('store_id', Filament::getTenant()->id)->pluck('name', 'id'))
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
