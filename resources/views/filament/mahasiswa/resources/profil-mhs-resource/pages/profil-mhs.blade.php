<x-filament::page>
    {{ $this->form }}

    <div class="mt-4 flex items-center gap-4">
        <x-filament::button wire:click="submit">
            Simpan Perubahan
        </x-filament::button>

        <a href="{{ \App\Filament\Mahasiswa\Resources\ProfilMhsResource::getUrl('index') }}">
            <x-filament::button color="secondary">
                Batal
            </x-filament::button>
        </a>
    </div>
</x-filament::page>
