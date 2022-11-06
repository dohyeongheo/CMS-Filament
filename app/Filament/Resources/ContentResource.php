<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\ContentResource\Pages;
use App\Filament\Resources\ContentResource\RelationManagers;
use App\Models\Content;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\GlobalSearch\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PHPUnit\Framework\Reorderable;

class ContentResource extends Resource
{
    protected static ?string $model = Content::class;

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'detail'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            '컨텐츠 타이틀' => $record->title,
            '컨텐츠 디테일' => $record->detail,
        ];
    }

    // public static function getGlobalSearchResultActions(Model $record): array
    // {
    //     return [
    //         Action::make('edit')
    //         ->iconButton()
    //             ->icon('heroicon-s-pencil')
    //             ->url(static::getUrl('edit', ['record' => $record])),
    //     ];
    // }

    protected static ?string $NavigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = '컨텐츠';
    protected static ?string $navigationGroup = '컨텐츠 관리 시스템';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }


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
            ->filters(
                [
                    SelectFilter::make('category')->relationship('category', 'title'),
                    SelectFilter::make('contentType')
                        ->multiple()
                        ->options([
                            1 => '사진',
                            2 => '영상',
                        ]),
                    SelectFilter::make('isPublished')
                        ->options([
                            true => '발행',
                            false => '미발행',
                        ])
                ],
                layout: Layout::AboveContent,
            )
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export')
            ])
            ->reorderable('id');
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
            'index' => Pages\ListContents::route('/'),
            'create' => Pages\CreateContent::route('/create'),
            'edit' => Pages\EditContent::route('/{record}/edit'),
        ];
    }
}
