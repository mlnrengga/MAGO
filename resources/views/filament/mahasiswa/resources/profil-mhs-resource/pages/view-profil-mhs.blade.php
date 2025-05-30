<x-filament::page>
    <div class="space-y-4 max-w-xl mx-auto">
        <div class="text-center">
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil"
                     class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
            @endif

            <h2 class="text-xl font-bold text-black-900 dark:text-white-100">{{ $user->nama }}</h2>
            <p class="text-black-600 dark:text-white-300">NIM: {{ $user->mahasiswa->nim ?? '-' }}</p>
        </div>

        <div class="bg-black dark:bg-white-800 rounded-lg shadow p-4 space-y-2 text-white-700 dark:text-black-300">
            <p><strong>Alamat:</strong> {{ $user->alamat }}</p>
            <p><strong>No Telepon:</strong> {{ $user->no_telepon }}</p>
            <p><strong>Password:</strong> ********</p>
        </div>

        <div class="text-center mt-4">
            <a href="{{ \App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages\ProfilMhs::getUrl() }}">
                <x-filament::button>
                    Edit Profil
                </x-filament::button>
            </a>
        </div>
    </div>
</x-filament::page>
