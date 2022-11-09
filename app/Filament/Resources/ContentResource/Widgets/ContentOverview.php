<?php

namespace App\Filament\Resources\ContentResource\Widgets;

use App\Models\Content;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ContentOverview extends BaseWidget
{
    protected function getCards(): array
    {

        return [
            Card::make('컨텐츠 개수', Content::count())
                ->description('32k increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('사진 컨텐츠 개수', Content::where('contentType', 1)->count())
                ->description('3% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('영상 컨텐츠 개수', Content::where('contentType', 2)->count())
                ->description('3% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('배포된 컨텐츠 개수', Content::where('isPublished', true)->count())
                ->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('danger'),
            Card::make('배포 보류 컨텐츠 개수', Content::where('isPublished', false)->count())
                ->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('danger'),
            Card::make('일 평균 컨텐츠 업로드 개수', Content::groupBy('created_at')->count())
                ->description('3% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),

        ];
    }
}
