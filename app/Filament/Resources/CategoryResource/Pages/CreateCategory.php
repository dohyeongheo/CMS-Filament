<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Notifications\Notification;
use App\Filament\Resources\CategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
