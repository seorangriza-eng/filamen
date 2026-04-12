<?php

namespace App\Filament\Resources\Coas\Pages;

use App\Filament\Resources\Coas\CoaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCoa extends CreateRecord
{
    protected static string $resource = CoaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
