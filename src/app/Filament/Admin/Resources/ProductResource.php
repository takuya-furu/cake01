<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cake';
    protected static ?string $navigationLabel = '商品';
    protected static ?string $modelLabel = '商品';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('基本情報')->schema([
                TextInput::make('name')
                    ->label('商品名')
                    ->required()
                    ->maxLength(200),
                Select::make('category_id')
                    ->label('カテゴリ')
                    ->options(
                        Category::where('is_active', true)
                            ->orderBy('sort_order')
                            ->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable(),
                TextInput::make('price')
                    ->label('価格 (円)')
                    ->required()
                    ->numeric()
                    ->prefix('¥'),
                Textarea::make('description')
                    ->label('説明')
                    ->rows(4)
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('商品画像')->schema([
                FileUpload::make('image')
                    ->label('画像')
                    ->image()
                    ->directory('products')
                    ->imageEditor()
                    ->maxSize(5120),
            ]),

            Section::make('表示設定')->schema([
                Toggle::make('is_pickup')
                    ->label('ピックアップ (トップページ表示)')
                    ->helperText('ONにするとトップページのおすすめ欄に表示されます'),
                Toggle::make('is_seasonal')
                    ->label('季節限定商品'),
                DateTimePicker::make('published_at')
                    ->label('公開開始日時')
                    ->native(false),
                DateTimePicker::make('unpublished_at')
                    ->label('公開終了日時')
                    ->native(false),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('画像')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->label('商品名')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('カテゴリ')
                    ->badge(),
                TextColumn::make('price')
                    ->label('価格')
                    ->formatStateUsing(fn ($state) => '¥' . number_format($state))
                    ->sortable(),
                IconColumn::make('is_pickup')
                    ->label('PU')
                    ->boolean(),
                IconColumn::make('is_seasonal')
                    ->label('季節')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('公開開始')
                    ->dateTime('Y/m/d')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('カテゴリ')
                    ->options(Category::pluck('name', 'id')),
                Filter::make('is_pickup')
                    ->label('ピックアップのみ')
                    ->query(fn (Builder $query) => $query->where('is_pickup', true)),
                Filter::make('is_seasonal')
                    ->label('季節商品のみ')
                    ->query(fn (Builder $query) => $query->where('is_seasonal', true)),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([EditAction::make()])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
