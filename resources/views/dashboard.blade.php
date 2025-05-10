@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-6 gap-x-8">
        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-thermometer-low text-4xl text-blue-800"></i>
            <h1 class="text-center">Suhu</h1>
            <h1 class="text-xl text-center font-extrabold">{{ $latest_measurement->temp }}</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-reception-2 text-4xl text-blue-800"></i>
            <h1 class="text-center">Nilai pH</h1>
            <h1 class="text-xl text-center font-extrabold">{{ $latest_measurement->ph }}</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-droplet-half text-4xl text-blue-800"></i>
            <h1 class="text-center">Kekeruhan</h1>
            <h1 class="text-xl text-center font-extrabold">{{ $latest_measurement->turbidity }}</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-ui-radios-grid text-4xl text-blue-800"></i>
            <h1 class="text-center">Padatan Terlarut</h1>
            <h1 class="text-xl text-center font-extrabold">{{ $latest_measurement->tds }}</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-trash2 text-4xl text-blue-800"></i>
            <h1 class="text-center">Deteksi Sampah</h1>
            <div class="text-xl font-semibold bg-slate-400 animate-pulse h-[25px] w-1/3"></div>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-stars text-4xl text-blue-800"></i>
            <h1 class="text-center">Kualitas Air</h1>
            @if($latest_measurement->quality == 'Very Bad')
                <h1 class="text-xl text-center font-extrabold text-red-600">Sangat Buruk</h1>
            @elseif($latest_measurement->quality == 'Bad')
                <h1 class="text-xl text-center font-extrabold text-orange-600">Buruk</h1>
            @elseif($latest_measurement->quality == 'Moderate')
                <h1 class="text-xl text-center font-extrabold text-yellow-600">Sedang</h1>
            @elseif($latest_measurement->quality == 'Good')
                <h1 class="text-xl text-center font-extrabold text-green-700">Baik</h1>
            @elseif($latest_measurement->quality == 'Excellent')
                <h1 class="text-xl text-center font-extrabold text-blue-600">Sangat Baik</h1>
            @endif
        </x-section-container>
    </div>

    <div class="flex mt-8 space-x-8">
        <x-section-container title="Pemantauan Terkini" class="w-3/5">
            <!-- Placeholder -->
            <div class="bg-slate-400 h-[400px] animate-pulse"></div>
        </x-section-container>

        <x-section-container title="Peringatan" class="w-2/5">
            <div class="max-h-[400px] overflow-y-auto">
                @forelse ($warnings as $warning)
                    <div class="mb-8 px-4 py-2 border-l-4 @if($warning->category == 'Bad') border-orange-600 @elseif($warning->category == 'Very Bad') border-red-600 @endif bg-white shadow-md">
                        <div class="w-full flex justify-between items-center mb-4">
                            <h1 class="font-extrabold text-blue-900">{{ Carbon\Carbon::parse($warning->date_and_time)->format('d M Y, H:i') }}</h1>
                            @if($warning->category == 'Bad')
                                <span class="text-white px-3 py-0.5 rounded-lg bg-orange-600"><i class="bi bi-exclamation-triangle"></i> Buruk</span>
                            @elseif($warning->category == 'Very Bad')
                                <span class="text-white px-3 py-0.5 rounded-lg bg-red-600"><i class="bi bi-exclamation-triangle-fill"></i> Sangat Buruk</span>
                            @endif
                        </div>
                        <div>{!! $warning->message !!}</div>
                    </div>
                @empty
                    - Belum ada peringatan terkini -
                @endforelse
            </div>
        </x-section-container>
    </div>
@endsection
