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
                    TextInput::make('nama_dokumen')
                        ->label('Nama Dokumen')
                        ->required()
                        ->maxLength(255),

                    Select::make('jenis_dokumen')
                        ->label('Jenis Dokumen')
                        ->options([
                            'CV' => 'CV',
                            'KHS' => 'KHS',
                            'Sertifikat' => 'Sertifikat',
                            'Surat Pengantar' => 'Surat Pengantar',
                        ])
                        ->required(),

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
                        ->required(),
                ])
                ->deletable()
                ->reorderable()
                ->collapsible()
                ->addActionLabel('Tambah Dokumen')
                ->itemLabel(fn(array $state): ?string => $state['nama_dokumen'] ?? null),
        ]);
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
