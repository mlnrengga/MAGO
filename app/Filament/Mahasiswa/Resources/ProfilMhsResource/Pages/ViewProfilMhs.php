<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages\EditProfil;
use App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages\EditPengalaman;
use App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages\EditDokumen;
use Filament\Forms\Components\Builder;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Support\Facades\Storage;

class ViewProfilMhs extends ViewRecord
{
    protected static string $resource = ProfilMhsResource::class;

    protected static ?string $title = 'Profil Saya';

    protected static ?string $navigationLabel = 'Profil Saya';

    protected static ?string $slug = 'profil-saya';

    protected function getRecordQuery(): Builder
    {
        return parent::getRecordQuery()->with(['dokumen']);
    }


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                // SECTION PROFIL
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
                                        TextEntry::make('nim')->label('NIM'),
                                        TextEntry::make('prodi.nama_prodi')->label('Program Studi'),
                                        TextEntry::make('ipk')->label('IPK'),
                                        TextEntry::make('semester')->label('Semester'),
                                        TextEntry::make('user.alamat')->label('Alamat'),
                                        TextEntry::make('user.no_telepon')->label('No. Telepon'),
                                        TextEntry::make('user.password')
                                            ->label('Password')
                                            ->formatStateUsing(fn() => '******'),
                                    ])
                                    ->columnSpan(3),
                            ]),
                    ])
                    ->headerActions([
                        Action::make('edit_profil')
                            ->label('Edit Profil')
                            ->action(fn($record) => redirect(EditProfil::getUrl(['record' => $record])))
                            ->color('primary'),
                    ]),

                // SECTION PENGALAMAN
                Section::make('Pengalaman')
                    ->schema([
                        TextEntry::make('pengalaman')
                            ->label('')
                            ->placeholder('Belum ada pengalaman yang ditambahkan'),
                    ])
                    ->headerActions([
                        Action::make('edit_pengalaman')
                            ->label(fn($record) => $record->pengalaman ? 'Edit Pengalaman' : 'Tambah Pengalaman')
                            ->action(fn($record) => redirect(EditPengalaman::getUrl(['record' => $record])))
                            ->color(fn($record) => $record->pengalaman ? 'primary' : 'primary'),
                    ]),

                // SECTION DOKUMEN
                Section::make('Dokumen')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextEntry::make('no_dokumen')
                                    ->label('')
                                    ->state('Belum ada dokumen yang diupload')
                                    ->visible(fn($record) => $record->dokumen->isEmpty()),
                            ]),

                        RepeatableEntry::make('dokumen')
                            ->label('')
                            ->visible(fn($record) => $record->dokumen->isNotEmpty())
                            ->schema([
                                TextEntry::make('jenis_dokumen')->label('Jenis Dokumen'),
                                // TextEntry::make('nama_dokumen')->label('Nama Dokumen'),
                                TextEntry::make('path_dokumen')
                                    ->label('File')
                                    ->formatStateUsing(function ($state, $record) {
                                        $extension = pathinfo($state, PATHINFO_EXTENSION);
                                        return $record->nama_dokumen . '.' . $extension;
                                    })
                                    ->url(fn($record) => asset('storage/' . $record->path_dokumen), true)
                                    ->openUrlInNewTab()
                                    ->color('primary'),
                            ])
                            ->columns(3),
                    ])
                    ->headerActions([
                        Action::make('edit_dokumen')
                            ->label(fn($record) => $record->dokumen->count() > 0 ? 'Edit Dokumen' : 'Tambah Dokumen')
                            ->action(fn($record) => redirect(EditDokumen::getUrl(['record' => $record])))
                            ->color('primary'),
                    ]),
            ]);
    }
}
