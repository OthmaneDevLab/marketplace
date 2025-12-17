<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
{
    return $form->schema([
        Select::make('store_id')
            ->relationship('store', 'name')
            ->searchable()
            ->required(),

        TextInput::make('name')
            ->required()
            ->live(onBlur: true)
            ->afterStateUpdated(fn ($state, callable $set) =>
                $set('slug', Str::slug($state))
            ),

        TextInput::make('slug')
            ->required()
            ->unique(ignoreRecord: true),

        RichEditor::make('description')
            ->nullable(),

        TextInput::make('price')
            ->numeric()
            ->step(0.01)
            ->required(),

        Select::make('category_id')
            ->relationship('category', 'name')
            ->searchable()
            ->nullable(),

        TextInput::make('stock')
            ->numeric()
            ->default(0)
            ->required(),
    ]);
}


    public static function table(Table $table): Table
    {
        return $table->columns([
        TextColumn::make('name'),
        TextColumn::make('price')->money('usd', true),
        TextColumn::make('stock'),
        TextColumn::make('category.name'),
        TextColumn::make('created_at')->date(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
