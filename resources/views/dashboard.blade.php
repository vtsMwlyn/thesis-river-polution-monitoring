@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-5 gap-x-8">
        <x-section-container class="flex flex-col items-center gap-2 py-8">
            <i class="bi bi-thermometer-low text-4xl text-blue-800"></i>
            <h1>Suhu</h1>
            <div class="text-xl font-semibold bg-slate-400 animate-pulse h-[25px] w-1/3"></div>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2 py-8">
            <i class="bi bi-reception-2 text-4xl text-blue-800"></i>
            <h1>Nilai pH</h1>
            <div class="text-xl font-semibold bg-slate-400 animate-pulse h-[25px] w-1/3"></div>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2 py-8">
            <i class="bi bi-droplet-half text-4xl text-blue-800"></i>
            <h1>Tingkat Kekeruhan</h1>
            <div class="text-xl font-semibold bg-slate-400 animate-pulse h-[25px] w-1/3"></div>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2 py-8">
            <i class="bi bi-ui-radios-grid text-4xl text-blue-800"></i>
            <h1>Padatan Terlarut</h1>
            <div class="text-xl font-semibold bg-slate-400 animate-pulse h-[25px] w-1/3"></div>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2 py-8">
            <i class="bi bi-trash2 text-4xl text-blue-800"></i>
            <h1>Sampah Terdeteksi</h1>
            <div class="text-xl font-semibold bg-slate-400 animate-pulse h-[25px] w-1/3"></div>
        </x-section-container>
    </div>

    <div class="flex mt-8 space-x-8">
        <x-section-container title="Tren Kualitas Air" class="w-2/3">
            <!-- Placeholder -->
            <div class="bg-slate-400 h-[500px] animate-pulse"></div>
        </x-section-container>

        <x-section-container title="Peringatan" class="w-1/3">
            <!--Placeholder -->
            <div class="bg-slate-400 w-11/12 h-[10px] animate-pulse"></div>
            <div class="bg-slate-400 w-full h-[10px] mt-2 animate-pulse"></div>
            <div class="bg-slate-400 w-5/6 h-[10px] mt-2 animate-pulse"></div>
        </x-section-container>
    </div>
@endsection
