@extends('layouts.app')

@section('popup')
    <x-popup title="Rincian Data" class="w-1/2" id="water-quality-parameters-popup">
        <table class="w-full">
            <thead>
                <th>Parameter</th>
                <th>Nilai</th>
            </thead>
            <tbody>
                <tr>
                    <td>Suhu (<sup>0</sup>C)</td>
                    <td id="popup-temp">N/A</td>
                </tr>
                <tr class="bg-slate-200">
                    <td>Nilai pH</td>
                    <td id="popup-ph">N/A</td>
                </tr>
                <tr>
                    <td>Tingkat Kekeruhan (NTU)</td>
                    <td id="popup-turbidity">N/A</td>
                </tr>
                <tr class="bg-slate-200">
                    <td>Jumlah Padatan Terlarut (ppm)</td>
                    <td id="popup-tds">N/A</td>
                </tr>
            </tbody>
        </table>
    </x-popup>
@endsection

@section('content')
    <x-section-container title="Tingkat Pencemaran">
        <div class="flex mb-6">
            <a href="{{ route('polution.index', ['show' => 'chart']) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ !request('show') || request('show') == 'chart' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Grafik</a>
            <a href="{{ route('polution.index', ['show' => 'table']) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ request('show') == 'table' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Tabel</a>
        </div>

        @if(!request('show') || request('show') == 'chart')
            <div class="grid grid-cols-2 gap-8">
                <div class="flex flex-col gap-3">
                    <h1>Indeks Kualitas Air</h1>
                    <div class="bg-slate-400 animate-pulse h-[300px]"></div>
                </div>
                <div class="flex flex-col gap-3">
                    <h1>Tingkat Pencemaran</h1>
                    <div class="bg-slate-400 animate-pulse h-[300px]"></div>
                </div>
            </div>
        @else
            <table class="w-full">
                <thead>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Tingkat Pencemaran</th>
                    <th>Detail</th>
                </thead>
                <tbody>
                    <tr>
                        <td>dd/mm/yyyy</td>
                        <td>hh:mm</td>
                        <td>N/A</td>
                        <td>
                            <button type="button" class="show-water-quality-parameters inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="bg-slate-200">
                        <td>dd/mm/yyyy</td>
                        <td>hh:mm</td>
                        <td>N/A</td>
                        <td>
                            <button type="button" class="show-water-quality-parameters inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>dd/mm/yyyy</td>
                        <td>hh:mm</td>
                        <td>N/A</td>
                        <td>
                            <button type="button" class="show-water-quality-parameters inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-section-container>
@endsection
