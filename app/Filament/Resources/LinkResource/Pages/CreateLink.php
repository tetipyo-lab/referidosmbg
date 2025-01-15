<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\LinkeToService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;
   
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
