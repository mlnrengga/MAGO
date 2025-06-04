<div class="space-y-4 p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg font-bold mb-2">Informasi Aktivitas</h3>
            <div class="space-y-2">
                <div>
                    <span class="font-semibold">Tanggal:</span> 
                    {{ \Carbon\Carbon::parse($record->tanggal_log)->format('d M Y') }}
                </div>
                <div>
                    <span class="font-semibold">Status:</span> 
                    <span class="px-2 py-1 rounded-full text-xs 
                        @if($record->status === 'masuk') bg-green-100 text-green-800
                        @elseif($record->status === 'izin') bg-yellow-100 text-yellow-800
                        @elseif($record->status === 'sakit') bg-red-100 text-red-800
                        @elseif($record->status === 'cuti') bg-blue-100 text-blue-800
                        @endif">
                        {{ ucfirst($record->status) }}
                    </span>
                </div>
                <div>
                    <span class="font-semibold">Keterangan:</span><br>
                    <p class="mt-1">{{ $record->keterangan }}</p>
                </div>
                @if($record->feedback_progres)
                <div>
                    <span class="font-semibold">Feedback:</span><br>
                    <p class="mt-1">{{ $record->feedback_progres }}</p>
                </div>
                @endif
            </div>
        </div>
        <div>
            <h3 class="text-lg font-bold mb-2">File Bukti</h3>
            <img src="{{ $record->file_bukti }}" alt="Bukti" class="w-full h-auto rounded-lg shadow-md">
        </div>
    </div>
</div>