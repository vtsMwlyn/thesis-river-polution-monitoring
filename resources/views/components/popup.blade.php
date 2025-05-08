@props(['title' => null])

<div class="popup-container w-full h-full fixed top-0 z-50 flex items-center justify-center" style="background: rgba(0, 0, 0, 0.7); display: none;">
    <div {!! $attributes->merge(['class' => 'bg-white rounded-xl p-6']) !!}>
        @if($title)
            <div class="w-full flex justify-between">
                <h1 class="font-bold text-lg">{{ $title }}</h1>
                <button type="button" class="popup-dismiss">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="w-full h-0.5 mt-2 mb-4 bg-slate-400"></div>
        @endif

        {{ $slot }}
    </div>
</div>
