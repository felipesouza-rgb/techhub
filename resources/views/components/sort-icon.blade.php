@props(['dir' => 'asc'])

<span class="inline-block w-3 text-gray-400 align-middle">
    @if($dir === 'asc')
        &#9650; {{-- ▲ --}}
    @else
        &#9660; {{-- ▼ --}}
    @endif
</span>
