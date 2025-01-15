<?php

namespace App\Filament\Resources\ReferredLinkResource\Pages;

use App\Filament\Resources\ReferredLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReferredLinks extends ListRecords
{
    protected static string $resource = ReferredLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
