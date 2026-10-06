@php
    $promoBarItems = [
        ['FREE SHIPPING NATIONWIDE', 'Next day & standard delivery*'],
        ['ASICS GEL-CUMULUS', 'Where comfort pursues us'],
        ['CLICK AND COLLECT', 'Available in web & app'],
        ['NEW ARRIVALS', 'Just landed — fresh picks'],
        ['FLASH SALE', 'Up to 70% off — today only'],
        ['EXCLUSIVE PERKS', 'Early access — join now'],
    ];
@endphp

{{-- Promo Bar --}}
<div class="border-y border-yellow-400 bg-brand-yellow font-bold uppercase tracking-tight text-black overflow-hidden"
    role="region" aria-label="Promo berjalan">
    <div class="mx-auto max-w-7xl px-4 py-2 lg:px-8">
        <div class="flex items-center gap-x-4 whitespace-nowrap text-[10px] animate-promo-scroll">
            @foreach ($promoBarItems as $promo)
                <span class="flex items-center gap-1.5 shrink-0">
                    <span>{{ $promo[0] }}</span>
                    <span class="text-[8px] font-medium">—</span>
                    <span>{{ $promo[1] }}</span>
                </span>
                <span class="text-gray-500 shrink-0" aria-hidden="true">|</span>
            @endforeach
            @foreach ($promoBarItems as $promo)
                <span class="flex items-center gap-1.5 shrink-0">
                    <span>{{ $promo[0] }}</span>
                    <span class="text-[8px] font-medium">—</span>
                    <span>{{ $promo[1] }}</span>
                </span>
                <span class="text-gray-500 shrink-0" aria-hidden="true">|</span>
            @endforeach
        </div>
    </div>
</div>