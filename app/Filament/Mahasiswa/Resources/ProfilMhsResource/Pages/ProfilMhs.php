<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class ProfilMhs extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = ProfilMhsResource::class;

    protected static string $view = 'filament.mahasiswa.resources.profil-mhs-resource.pages.profil-mhs';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $title = 'Edit Profil';
    protected static ?string $navigationLabel = 'Edit Profil';
    protected static ?string $slug = 'edit';

    public $nama, $alamat, $no_telepon, $profile_picture, $password;
    public $nim, $ipk, $semester;

    public function mount(): void
    {
        $user = auth()->user();

        $this->nama = $user->nama;
        $this->alamat = $user->alamat;
        $this->no_telepon = $user->no_telepon;
        $this->profile_picture = $user->profile_picture;

        $this->nim = $user->mahasiswa->nim ?? null;
        $this->ipk = $user->mahasiswa->ipk ?? null;
        $this->semester = $user->mahasiswa->semester ?? null;

        $this->form->fill([
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_telepon' => $this->no_telepon,
            'profile_picture' => $this->profile_picture,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [

            Forms\Components\FileUpload::make('profile_picture')
                ->label('Foto Profil')
                ->image()
                ->imagePreviewHeight('150') // Lebih kecil = lebih cepat
                ->disk('public')
                ->directory('foto-profil')
                ->visibility('public')
                ->nullable(),
                
            Forms\Components\TextInput::make('nama')
                ->label('Nama')
                ->required(),

            Forms\Components\TextInput::make('nim')
                ->label('NIM')
                ->disabled(),

            Forms\Components\Textarea::make('alamat')
                ->label('Alamat')
                ->required(),

            Forms\Components\TextInput::make('ipk')
                ->label('IPK')
                ->disabled(),

            Forms\Components\TextInput::make('semester')
                ->label('Semester')
                ->disabled(),

            Forms\Components\TextInput::make('no_telepon')
                ->label('No Telepon')
                ->required(),

            Forms\Components\TextInput::make('password')
                ->label('Password Baru')
                ->password()
                ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                ->dehydrated(fn($state) => filled($state)),

        ];
    }

    public function submit()
    {
        /** @var \App\Models\UserModel $user */
        $user = auth()->user();
        $data = $this->form->getState();

        // Update data yang bisa diubah
        $user->nama = $data['nama'];
        $user->alamat = $data['alamat'];
        $user->no_telepon = $data['no_telepon'];

        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }

        if (!empty($data['profile_picture']) && $data['profile_picture'] !== $user->profile_picture) {
            // Hapus foto lama kalau ada
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $data['profile_picture'];
        }

        if (empty($data['profile_picture']) && $user->profile_picture) {
            // User menghapus foto
            if (Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = null;
        }


        $user->save();

        Notification::make()
            ->title('Profil berhasil diperbarui.')
            ->success()
            ->send();

        return redirect(ProfilMhsResource::getUrl('index'));
    }

    protected function getFormModel(): \App\Models\UserModel
    {
        return auth()->user();
    }
}
