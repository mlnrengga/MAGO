<?php

namespace App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages;

use App\Filament\Pembimbing\Resources\ProfilDospemResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ImageEntry; 
use Filament\Infolists\Infolist;

class ViewProfilDospem extends ViewRecord
{
    protected static string $resource = ProfilDospemResource::class;

    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $title = 'Profil Saya';

    protected function getHeaderActions(): array
    {
        return [

            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Profil')
                    ->description('Detail pribadi dan kontak Anda.')
                    ->schema([
                        TextEntry::make('user.nama')
                            ->label('Nama'),
                        TextEntry::make('nip')
                            ->label('NIP'), 
                        TextEntry::make('user.no_telepon')
                            ->label('No. Telepon'),
                        TextEntry::make('user.alamat')
                            ->label('Alamat'),
                        ImageEntry::make('user.profile_picture')
                            ->label('Foto Profil')
                            ->disk('public'), 
                    ])->columns(2),

                Section::make('Bidang Keahlian')
                    ->description('Bidang keahlian yang relevan.')
                    ->schema([
                        TextEntry::make('bidangKeahlian.nama_bidang_keahlian')
                            ->label('Bidang Keahlian')
                            ->listWithLineBreaks() 
                            ->bulleted(), 
                    ]),
            ]);
    }
}