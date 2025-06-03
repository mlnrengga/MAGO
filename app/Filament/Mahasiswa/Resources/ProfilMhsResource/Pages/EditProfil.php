<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditProfil extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = ProfilMhsResource::class;

    protected static string $view = 'filament.mahasiswa.resources.profil-mhs-resource.pages.edit-profil';

    protected static ?string $title = 'Edit Profil';
    protected static ?string $navigationLabel = 'Edit Profil';
    protected static ?string $slug = 'edit';

    // Properti data yang digunakan
    public $nama, $alamat, $no_telepon, $profile_picture, $password, $password_confirmation;
    public $nim, $ipk, $semester, $prodi;


    public function mount(): void
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        $this->form->fill([
            'nama' => $user->nama,
            'alamat' => $user->alamat,
            'no_telepon' => $user->no_telepon,
            'profile_picture' => $user->profile_picture,
            'nim' => $mahasiswa->nim ?? null,
            'prodi' => $mahasiswa->prodi->nama_prodi ?? null,
            'ipk' => $mahasiswa->ipk ?? null,
            'semester' => $mahasiswa->semester ?? null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Foto Profil')
                    ->schema([
                        FileUpload::make('profile_picture')
                            ->label('Foto Profil Saat Ini')
                            ->previewable(true)
                            ->image()
                            // ->imagePreviewHeight('150')
                            ->disk('public')
                            ->directory('foto-profil')
                            ->visibility('public')
                            ->panelLayout('integrated')
                            ->openable()
                            ->downloadable()
                            ->helperText('Kosongkan jika tidak ingin mengubah foto')
                            ->nullable(),
                    ]),

                Section::make('Informasi Mahasiswa')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required(),

                        TextInput::make('nim')
                            ->label('NIM')
                            ->disabled()
                            ->dehydrated()
                            ->helperText('NIM tidak dapat diubah'),

                        TextInput::make('no_telepon')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->required(),

                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->rows(2),

                    ])
                    ->columns(2),

                Section::make('Akademik')
                    ->schema([
                        TextInput::make('ipk')
                            ->label('IPK')
                            ->numeric()
                            ->step(0.01)
                            ->disabled(),

                        TextInput::make('prodi')
                            ->label('Program Studi')
                            ->disabled(),

                        TextInput::make('semester')
                            ->label('Semester Saat Ini')
                            ->numeric()
                            ->disabled(),
                    ])
                    ->columns(2),

                Section::make('Keamanan')
                    ->schema([
                        TextInput::make('password')
                            ->label('Password Baru')
                            ->password()
                            ->placeholder('Masukkan password baru')
                            ->helperText('Minimal 8 karakter. Kosongkan jika tidak ingin mengubah')
                            ->minLength(8)
                            ->confirmed()
                            ->dehydrated(fn ($state) => filled($state))
                            ->columns(2),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password Baru')
                            ->password()
                            ->same('password')
                            ->dehydrated(false)
                            ->columns(2),
                    ])
                    ->columns(2),
            ]);
    }
    public function submit()
    {
        try {
            /** @var \App\Models\UserModel $user */
            $user = auth()->user();
            $data = $this->form->getState();

            // Update data yang bisa diubah
            $user->nama = $data['nama'];
            $user->alamat = $data['alamat'];
            $user->no_telepon = $data['no_telepon'];

            // Handle password update
            if (!empty($data['password'])) {
               $user->password = Hash::make($data['password']);
            }

            // Handle profile picture update
            if (isset($data['profile_picture'])) {
                if (!empty($data['profile_picture']) && $data['profile_picture'] !== $user->profile_picture) {
                    // Hapus foto lama
                    if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                        Storage::disk('public')->delete($user->profile_picture);
                    }
                    $user->profile_picture = $data['profile_picture'];
                } elseif (empty($data['profile_picture']) && $user->profile_picture) {
                    // User menghapus foto
                    if (Storage::disk('public')->exists($user->profile_picture)) {
                        Storage::disk('public')->delete($user->profile_picture);
                    }
                    $user->profile_picture = null;
                }
            }

            $user->save();

            Notification::make()
                ->title('Profil berhasil diperbarui')
                ->success()
                ->send();

            // Redirect ke halaman view profil
            return redirect(ProfilMhsResource\Pages\ViewProfilMhs::getUrl(['record' => $user->mahasiswa]));
        } catch (\Exception $e) {
            Notification::make()
                ->title('Terjadi kesalahan')
                ->body('Gagal menyimpan data profil. Silakan coba lagi.')
                ->danger()
                ->send();

            throw $e;
        }
    }

    protected function getFormModel(): \App\Models\UserModel
    {
        return auth()->user();
    }
}
