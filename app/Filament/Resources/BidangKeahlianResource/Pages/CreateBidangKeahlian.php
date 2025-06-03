<?php

namespace App\Filament\Resources\BidangKeahlianResource\Pages;

use App\Filament\Resources\BidangKeahlianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBidangKeahlian extends CreateRecord
{
    protected static string $resource = BidangKeahlianResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
