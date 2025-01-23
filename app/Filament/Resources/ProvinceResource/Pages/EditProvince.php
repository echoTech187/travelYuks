<?php

namespace App\Filament\Resources\ProvinceResource\Pages;

use App\Filament\Resources\ProvinceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProvince extends EditRecord
{
    protected static string $resource = ProvinceResource::class;

    protected static ?string $navigationLabel = 'Edit Provinsi';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
