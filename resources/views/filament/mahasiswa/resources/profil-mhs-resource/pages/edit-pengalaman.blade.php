<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="mt-6 flex items-center justify-between flex-wrap gap-4">
            <x-filament::button
                type="button"
                color="gray"
                tag="a"
                :href="\App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages\ViewProfilMhs::getUrl(['record' => auth()->user()->mahasiswa])">
                Cancel
            </x-filament::button>

            <div class="flex items-center gap-4">
                <x-filament::button
                    type="button"
                    color="danger"
                    wire:click="delete"
                    wire:loading.attr="disabled"
                    wire:target="delete">
                    Delete
                </x-filament::button>

                <x-filament::button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="submit">
                    Save Changes
                    <x-slot name="loadingIndicator">
                        <x-heroicon-o-arrow-path class="w-4 h-4 animate-spin" />
                    </x-slot>
                </x-filament::button>
            </div>
        </div>
    </form>
</x-filament-panels::page>
