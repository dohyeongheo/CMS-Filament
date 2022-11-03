<?php

namespace App\Filament\Resources\ContentResource\Pages;

use App\Filament\Resources\ContentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContents extends ListRecords
{
    protected static string $resource = ContentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
