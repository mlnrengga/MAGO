<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditDokumen extends EditRecord
{
    protected static string $resource = ProfilMhsResource::class;

    protected static ?string $title = 'Edit Dokumen';

    protected static string $view = 'filament.mahasiswa.resources.profil-mhs-resource.pages.edit-dokumen';

    public function form(Form $form): Form
    {
        return $form->schema([
            Repeater::make('dokumen')
                ->label('')
                ->relationship('dokumen')
                ->schema([
                    Select::make('jenis_dokumen')
                        ->label('Jenis Dokumen')
                        ->options([
                            'CV' => 'CV',
                            'KHS' => 'KHS',
                            'Sertifikat' => 'Sertifikat',
                            'Surat Pengantar' => 'Surat Pengantar',
                        ])
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                $mahasiswa = $this->record;
                                $namaMahasiswa = $mahasiswa->user->nama ?? 'Mahasiswa';
                                $timestamp = date('YmdHis');
                                
                                $set('nama_dokumen', $state . '_' . $namaMahasiswa . '_' . $timestamp);
                            }
                        }),

                    FileUpload::make('path_dokumen')
                        ->label('File Dokumen')
                        ->directory('dokumen')
                        ->acceptedFileTypes([
                            'application/pdf',
                            'image/*',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ])
                        ->maxSize(5120) // 5MB
                        ->required()
                        ->preserveFilenames(),

                    TextInput::make('nama_dokumen')
                        ->label('Nama Dokumen')
                        ->maxLength(255)
                        ->required()
                        ->default(function () {
                            $mahasiswa = $this->record;
                            $namaMahasiswa = $mahasiswa->user->nama ?? 'Mahasiswa';
                            $timestamp = date('YmdHs');
                            return 'Dokumen_' . $namaMahasiswa . '_' . $timestamp;
                        })
                        ->dehydrated()
                ])
                ->deletable()
                ->reorderable()
                ->collapsible()
                ->addActionLabel('Tambah Dokumen')
                ->itemLabel(fn(array $state): ?string => $state['jenis_dokumen'] . ' - ' . ($state['nama_dokumen'] ?? 'Dokumen')),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['nama_dokumen']) && !empty($data['jenis_dokumen'])) {
            $mahasiswa = $this->record;

            $namaMahasiswa = $mahasiswa->user->nama ?? 'Mahasiswa';
            $data['nama_dokumen'] = $data['jenis_dokumen'] . '_' . $namaMahasiswa;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['dokumen']) && is_array($data['dokumen'])) {
            $mahasiswa = $this->record;
            $namaMahasiswa = $mahasiswa->user->nama ?? 'Mahasiswa';

            foreach ($data['dokumen'] as $key => $dokumen) {
                if (!empty($dokumen['jenis_dokumen'])) {
                    $data['dokumen'][$key]['nama_dokumen'] = $dokumen['jenis_dokumen'] . '_' . $namaMahasiswa;
                } else {
                    $data['dokumen'][$key]['nama_dokumen'] = 'Dokumen_' . $namaMahasiswa;
                }
            }
        }

        return $data;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Dokumen berhasil diperbarui');
    }

    protected function getRedirectUrl(): string
    {
        return ProfilMhsResource\Pages\ViewProfilMhs::getUrl([
            'record' => $this->record,
        ]);
    }
}
