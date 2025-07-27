@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-6 gap-x-8">
        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-thermometer-low text-4xl text-blue-800"></i>
            <h1 class="text-center">Suhu</h1>
            <h1 class="text-2xl text-center font-extrabold">{{ $latest_sensor_data?->temp ?? 'N/A' }}</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-reception-2 text-4xl text-blue-800"></i>
            <h1 class="text-center">Nilai pH</h1>
            <h1 class="text-2xl text-center font-extrabold">{{ $latest_sensor_data?->ph ?? 'N/A' }}</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-droplet-half text-4xl text-blue-800"></i>
            <h1 class="text-center">Kekeruhan</h1>
            <h1 class="text-2xl text-center font-extrabold">{{ $latest_sensor_data?->turbidity ?? 'N/A' }}</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-ui-radios-grid text-4xl text-blue-800"></i>
            <h1 class="text-center">Padatan Terlarut</h1>
            <h1 class="text-2xl text-center font-extrabold">{{ $latest_sensor_data?->tds ?? 'N/A' }}</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-trash2 text-4xl text-blue-800"></i>
            <h1 class="text-center">Deteksi Sampah</h1>
            <h1 class="text-2xl text-center font-extrabold">{{ $latest_detection?->number ?? 'N/A' }}</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-stars text-4xl text-blue-800"></i>
            <h1 class="text-center">Kualitas Air</h1>
            @if($latest_sensor_data)
                @if($latest_sensor_data->quality == 'Very Bad')
                    <span class="text-white px-3 py-0.5 text-lg font-extrabold rounded-lg bg-red-600">Sangat Buruk</span>
                @elseif($latest_sensor_data->quality == 'Bad')
                    <span class="text-white px-3 py-0.5 text-lg font-extrabold rounded-lg bg-orange-600">Buruk</span>
                @elseif($latest_sensor_data->quality == 'Moderate')
                    <span class="text-white px-3 py-0.5 text-lg font-extrabold rounded-lg bg-yellow-600">Sedang</span>
                @elseif($latest_sensor_data->quality == 'Good')
                    <span class="text-white px-3 py-0.5 text-lg font-extrabold rounded-lg bg-green-700">Baik</span>
                @elseif($latest_sensor_data->quality == 'Excellent')
                    <span class="text-white px-3 py-0.5 text-lg font-extrabold rounded-lg bg-blue-600">Sangat Baik</span>
                @endif
            @else
                <h1 class="text-xl text-center font-extrabold">N/A</h1>
            @endif
        </x-section-container>
    </div>

    <div class="flex mt-8 space-x-8">
        <x-section-container title="Pemantauan Terkini" class="w-3/5">
            <!-- Placeholder -->
            <div class="w-full flex justify-center">
                @if($latest_detection)
                    <img src="{{ Storage::url('app/public/' . $latest_detection->image_path) }}" class="h-[400px]" style="object-fit: cover; object-position: center;" alt="Latest Monitoring">
                @else
                    <div class="bg-slate-400 animate-pulse h-[400px] w-full"></div>
                @endif
            </div>
        </x-section-container>

        <x-section-container title="Peringatan" class="w-2/5">
            <div class="max-h-[400px] overflow-y-auto">
                @forelse ($all_warnings as $warning)
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
                    <p class="text-center">- Belum ada peringatan terkini -</p>
                @endforelse
            </div>
        </x-section-container>
    </div>
@endsection
