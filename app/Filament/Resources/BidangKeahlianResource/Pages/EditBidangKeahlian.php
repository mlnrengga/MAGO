<?php

namespace App\Filament\Resources\BidangKeahlianResource\Pages;

use App\Filament\Resources\BidangKeahlianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBidangKeahlian extends EditRecord
{
    protected static string $resource = BidangKeahlianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
}
