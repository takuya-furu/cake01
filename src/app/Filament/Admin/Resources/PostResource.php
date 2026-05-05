<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'お知らせ';
    protected static ?string $modelLabel = 'お知らせ';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('記事内容')->schema([
                TextInput::make('title')
                    ->label('タイトル')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                RichEditor::make('body')
                    ->label('本文')
                    ->required()
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('posts')
                    ->toolbarButtons([
                        'h2', 'h3',
                        'bold', 'italic',
                        'bulletList', 'orderedList',
                        'link',
                        'attachFiles',
                        'undo', 'redo',
                    ])
                    ->columnSpanFull(),
            ]),

            Section::make('公開設定')->schema([
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
                TextColumn::make('title')
                    ->label('タイトル')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('published_at')
                    ->label('公開開始')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
                TextColumn::make('unpublished_at')
                    ->label('公開終了')
                    ->dateTime('Y/m/d H:i'),
            ])
            ->defaultSort('published_at', 'desc')
            ->actions([EditAction::make()])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
