@extends('layouts.app')

@section('content')
    <x-section-container title="Pengukuran Sensor">
        <div class="flex mb-6">
            <a href="{{ route('sensor.index', ['show' => 'chart']) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ !request('show') || request('show') == 'chart' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Grafik</a>
            <a href="{{ route('sensor.index', ['show' => 'table']) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ request('show') == 'table' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Tabel</a>
        </div>

        @if(!request('show') || request('show') == 'chart')
            <div class="grid grid-cols-2 gap-8">
                <div class="flex flex-col gap-3">
                    <h1>Suhu Air</h1>
                    <div class="bg-slate-400 animate-pulse h-[300px]"></div>
                </div>
                <div class="flex flex-col gap-3">
                    <h1>Nilai pH Air</h1>
                    <div class="bg-slate-400 animate-pulse h-[300px]"></div>
                </div>
                <div class="flex flex-col gap-3">
                    <h1>Tingkat Kekeruhan Air</h1>
                    <div class="bg-slate-400 animate-pulse h-[300px]"></div>
                </div>
                <div class="flex flex-col gap-3">
                    <h1>Total Padatan Terlarut Air</h1>
                    <div class="bg-slate-400 animate-pulse h-[300px]"></div>
                </div>
            </div>
        @else
            <table class="w-full">
                <thead>
                    <th>Waktu</th>
                    <th>Suhu</th>
                    <th>pH</th>
                    <th>Kekeruhan</th>
                    <th>Padatan Terlarut</th>
                </thead>
                <tbody>
                    <tr>
                        <td>dd/mm/yyyy hh:mm</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                    </tr>
                    <tr class="bg-slate-200">
                        <td>dd/mm/yyyy hh:mm</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                    </tr>
                    <tr>
                        <td>dd/mm/yyyy hh:mm</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-section-container>
@endsection
