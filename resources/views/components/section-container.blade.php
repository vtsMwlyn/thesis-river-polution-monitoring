@props(['title' => null])

<div {!! $attributes->merge(['class' => 'bg-white rounded-xl p-6 shadow-md']) !!}>
    @if($title)
        <h1 class="font-bold text-lg">{{ $title }}</h1>
        <div class="w-full h-0.5 mt-2 mb-4 bg-slate-400"></div>
    @endif

    {{ $slot }}
</div>
