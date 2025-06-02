<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;

class EditPengalaman extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ProfilMhsResource::class;
    protected static string $view = 'filament.mahasiswa.resources.profil-mhs-resource.pages.edit-pengalaman';

    public $pengalaman;

    public function mount(): void
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        $this->form->fill([
            'pengalaman' => $mahasiswa->pengalaman,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema($this->getFormSchema());
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Pengalaman')
                ->schema([
                    Textarea::make('pengalaman')
                        ->label('Pengalaman Saya')
                        ->rows(6)
                        ->required(),
                ]),
        ];
    }

    public function submit()
    {
        try {
            $user = auth()->user();
            $mahasiswa = $user->mahasiswa;

            $data = $this->form->getState();

            // Simpan pengalaman
            $mahasiswa->pengalaman = $data['pengalaman'];
            $mahasiswa->save();

            \Filament\Notifications\Notification::make()
                ->title('Pengalaman berhasil diperbarui')
                ->success()
                ->send();

            // Redirect ke halaman profil
            return redirect(ProfilMhsResource\Pages\ViewProfilMhs::getUrl(['record' => $mahasiswa]));
        } catch (\Exception $e) {
            \Filament\Notifications\Notification::make()
                ->title('Terjadi Kesalahan')
                ->body('Gagal memperbarui pengalaman. Silakan coba lagi.')
                ->danger()
                ->send();

            throw $e;
        }
    }

    public function delete()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        $mahasiswa->pengalaman = null;
        $mahasiswa->save();

        \Filament\Notifications\Notification::make()
            ->title('Pengalaman dihapus')
            ->success()
            ->send();

        return redirect(ProfilMhsResource\Pages\ViewProfilMhs::getUrl(['record' => $mahasiswa]));
    }
}
