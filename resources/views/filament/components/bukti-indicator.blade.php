{{-- @php
    $hasBukti = !empty($getState());
    // Warna yang lebih gelap untuk background
    $bgColor = $hasBukti ? '#cce5fb' : '#fcd5d5'; // Biru/merah yang lebih gelap
    $hoverBgColor = $hasBukti ? '#a3d0fa' : '#fab5b5'; // Warna hover yang lebih terang
    $textColor = $hasBukti ? '#0284c7' : '#dc2626';
    $borderColor = $hasBukti ? '#93c5fd' : '#fca5a5'; // Warna border
@endphp

<div 
    style="
        width: 100%;
        height: 100%;
        background-color: {{ $bgColor }};
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 180px;
        position: relative;
        border: 2px solid {{ $borderColor }};
        border-radius: 0.5rem;
        margin: 10px 0;
        transition: all 0.2s ease-in-out;
    "
    onmouseover="this.style.backgroundColor='{{ $hoverBgColor }}'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';"
    onmouseout="this.style.backgroundColor='{{ $bgColor }}'; this.style.boxShadow='none';"
>
    <div style="
        color: {{ $textColor }};
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 10px;
    ">
        @if($hasBukti)
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span style="font-weight: 500;">Bukti Aktivitas Tersedia</span>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span style="font-weight: 500;">Tidak Ada Bukti</span>
        @endif
    </div>
</div> --}}

@php
    $hasBukti = !empty($getState());
    $bgColor = $hasBukti ? '#cce5fb' : '#fcd5d5'; 
    $hoverBgColor = $hasBukti ? '#a3d0fa' : '#fab5b5';
    $textColor = $hasBukti ? '#0284c7' : '#dc2626'; 
    $borderColor = $hasBukti ? '#93c5fd' : '#fca5a5';
@endphp

<div 
    style="
        width: 100%;
        height: 100%;
        background-color: {{ $bgColor }};
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 180px;
        position: relative;
        border: 2px solid {{ $borderColor }};
        border-radius: 0.5rem;
        margin: 10px 0;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    "
    onmouseover="this.style.backgroundColor='{{ $hoverBgColor }}'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';"
    onmouseout="this.style.backgroundColor='{{ $bgColor }}'; this.style.boxShadow='none';"
>
    <div style="
        color: {{ $textColor }};
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 10px;
    ">
        @if($hasBukti)
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span style="font-weight: 500;">Bukti Aktivitas Tersedia</span>
            <span style="font-size: 0.8rem; opacity: 0.7;">Klik untuk melihat detail</span>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span style="font-weight: 500;">Tidak Ada Bukti</span>
            <span style="font-size: 0.8rem; opacity: 0.7;">Klik untuk melihat detail</span>
        @endif
    </div>
</div>