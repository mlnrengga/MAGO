<x-filament-panels::page>

    @php
        $dokumen = $record->dokumen ?? collect();
    @endphp

    @if ($dokumen->isEmpty())
        <div class="p-4 mb-6 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-center text-sm text-gray-500 dark:text-gray-400">
            <div class="flex items-center justify-center gap-2">
                <x-heroicon-o-document class="w-5 h-5 text-gray-400" />
                <span>Belum ada dokumen yang diupload</span>
            </div>
        </div>
    @endif

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <x-filament-panels::form.actions 
            :actions="$this->getCachedFormActions()" 
            :full-width="$this->hasFullWidthFormActions()" 
        />
    </x-filament-panels::form>

</x-filament-panels::page>
