<x-filament-panels::page>
    <form wire:submit="submit">
        {{ $this->form }}

        <div class="mt-6 flex items-center justify-end gap-4">
            <x-filament::button 
                type="button" 
                color="gray"
                tag="a"
                :href="\App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages\ViewProfilMhs::getUrl(['record' => auth()->user()->mahasiswa])"   >

                Cancel
            </x-filament::button>

            <x-filament::button 
                type="submit"
                wire:loading.attr="disabled"
                wire:target="submit"
            >
                Save Changes
                
                <x-slot name="loadingIndicator">
                    <x-heroicon-o-arrow-path class="w-4 h-4 animate-spin" />
                </x-slot>
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>