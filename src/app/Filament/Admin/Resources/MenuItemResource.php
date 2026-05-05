<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'イートインメニュー';
    protected static ?string $modelLabel = 'メニュー';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('メニュー情報')->schema([
                TextInput::make('name')
                    ->label('メニュー名')
                    ->required()
                    ->maxLength(200),
                Select::make('category')
                    ->label('種別')
                    ->options([
                        'cake'    => 'ケーキ',
                        'drink'   => 'ドリンク',
                        'food'    => 'フード',
                        'dessert' => 'デザート',
                    ])
                    ->required(),
                TextInput::make('price')
                    ->label('価格 (円)')
                    ->numeric()
                    ->prefix('¥'),
                Textarea::make('description')
                    ->label('説明')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('画像')->schema([
                FileUpload::make('image')
                    ->label('画像')
                    ->image()
                    ->directory('menu')
                    ->imageEditor()
                    ->maxSize(5120),
            ]),

            Section::make('表示設定')->schema([
                TextInput::make('sort_order')
                    ->label('並び順')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('表示する')
                    ->default(true),
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
                    ->label('メニュー名')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('種別')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'cake'    => 'ケーキ',
                        'drink'   => 'ドリンク',
                        'food'    => 'フード',
                        'dessert' => 'デザート',
                        default   => $state,
                    }),
                TextColumn::make('price')
                    ->label('価格')
                    ->formatStateUsing(fn ($state) => $state ? '¥' . number_format($state) : '-')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('並び順')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('表示')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('種別')
                    ->options([
                        'cake'    => 'ケーキ',
                        'drink'   => 'ドリンク',
                        'food'    => 'フード',
                        'dessert' => 'デザート',
                    ]),
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
            'index'  => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit'   => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
