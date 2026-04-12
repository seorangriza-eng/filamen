<?php

namespace App\Filament\Resources\Coas\Pages;

use App\Filament\Resources\Coas\CoaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCoa extends EditRecord
{
    protected static string $resource = CoaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
