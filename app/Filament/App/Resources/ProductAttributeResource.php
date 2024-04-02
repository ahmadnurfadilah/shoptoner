<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ProductAttributeResource\Pages;
use App\Filament\App\Resources\ProductAttributeResource\RelationManagers;
use App\Models\Product\ProductAttribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductAttributeResource extends Resource
{
    protected static ?string $model = ProductAttribute::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'Product';
    protected static ?string $navigationLabel = 'Attributes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('e.g: Color')
                    ->columnSpanFull(),
                // Forms\Components\TextInput::make('description')
                //     ->maxLength(150)
                //     ->columnSpanFull(),
                Forms\Components\TagsInput::make('terms')
                    ->required()
                    ->helperText('Attribute terms can be assigned to products and variations')
                    ->placeholder('e.g: Red, Green, Blue')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description('Attributes enable you to specify additional information about a product, like its size or color.')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('terms')
                    ->searchable(),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProductAttributes::route('/'),
        ];
    }
}
