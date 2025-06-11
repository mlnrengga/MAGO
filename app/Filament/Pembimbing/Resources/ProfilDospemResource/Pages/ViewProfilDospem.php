<?php

namespace App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages;

use App\Filament\Pembimbing\Resources\ProfilDospemResource;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Builder;

class ViewProfilDospem extends ViewRecord
{
    protected static string $resource = ProfilDospemResource::class;

    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $title = 'Profil Saya';

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // ===================== //
                // SECTION PROFIL
                // ===================== //
                Section::make('Informasi Profil')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                ImageEntry::make('user.profile_picture')
                                    ->label('')
                                    ->circular()
                                    ->visibility('private')
                                    ->width(250)
                                    ->height(250)
                                    ->defaultImageUrl(asset('assets/images/default.png'))
                                    ->disk('public'),

                                Grid::make()
                                    ->schema([
                                        TextEntry::make('user.nama')->label('Nama'),
                                        TextEntry::make('nip')->label('NIP'),
                                        TextEntry::make('user.no_telepon')->label('No. Telepon'),
                                        TextEntry::make('user.alamat')->label('Alamat'),
                                    ])
                                    ->columnSpan(3)
                                    ->extraAttributes([
                                        'style' => 'padding-top: 3.0rem;', // posisi biodata lebih turun
                                    ]),
                            ])
                    ])
                    ->extraAttributes([
                        'style' => 'min-height: 300px;',
                    ])
                    ->headerActions([
                        Action::make('edit_profil')
                            ->label('Edit Profil')
                            ->action(fn($record) => redirect(\App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages\EditProfilDospem::getUrl(['record' => $record])))
                            ->color('primary'),
                    ]),

                // ===================== //
                // SECTION KEAHLIAN
                // ===================== //
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

    protected function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user');
    }
}
