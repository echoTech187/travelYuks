<?php

namespace App\Filament\Resources\ZoneResource\Pages;

use Filament\Panel;
use Filament\Actions;
use App\Filament\Resources\ZoneResource;
use Filament\Resources\Pages\ListRecords;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;

class ListZones extends ListRecords
{
    protected static string $resource = ZoneResource::class;

  
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
    
}
