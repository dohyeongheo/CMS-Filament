<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContentRelationManager extends RelationManager
{
    protected static string $relationship = 'content';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'title')->required()->label('카테고리 선택'),
                        TextInput::make('title')->required()->label('컨텐츠 타이틀'),
                        RichEditor::make('detail')->required()->label('컨텐츠 디테일')
                            // ->disableToolbarButtons([
                            //     'attachFiles',
                            //     'codeBlock',
                            // ])
                            // ->fileAttachmentsVisibility('private')
                            ->fileAttachmentsDirectory('attachments'),
                        Select::make('contentType')->label('미디어 타입')
                            ->options([
                                '1' => '사진',
                                '2' => '영상'
                            ])
                            ->required(),
                        FileUpload::make('path')->label('컨텐츠 업로드')
                            ->directory('content'),
                        Toggle::make('isPublished')->label('컨텐츠 발행')
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('컨텐츠 타이틀'),
                TextColumn::make('detail')
                    ->label('컨텐츠 디테일')
                    ->html(),

                TextColumn::make('contentType')
                    ->label('컨텐츠 타입'),

                ImageColumn::make('path')
                    ->size(200)
                    ->label('미디어'),
                IconColumn::make('isPublished')
                    ->boolean()
                    ->label('발행여부'),
                TextColumn::make('created_at')->dateTime()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
