<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'カテゴリ';
    protected static ?string $modelLabel = 'カテゴリ';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('カテゴリ名')
                ->required()
                ->maxLength(100)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) =>
                    $set('slug', Str::slug($state))
                ),
            TextInput::make('slug')
                ->label('スラッグ (URL用)')
                ->required()
                ->maxLength(100)
                ->unique(ignoreRecord: true),
            TextInput::make('sort_order')
                ->label('並び順')
                ->numeric()
                ->default(0),
            Toggle::make('is_active')
                ->label('有効')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('カテゴリ名')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('スラッグ'),
                TextColumn::make('sort_order')
                    ->label('並び順')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('有効')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->actions([EditAction::make()])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
