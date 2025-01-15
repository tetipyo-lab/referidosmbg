<?php

namespace App\Filament\Resources\ReferredLinkResource\Pages;

use App\Filament\Resources\ReferredLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReferredLink extends EditRecord
{
    protected static string $resource = ReferredLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
