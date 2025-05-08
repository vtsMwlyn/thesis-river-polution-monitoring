@extends('layouts.app')

@section('content')
    <x-section-container title="Deteksi Sampah">
        <div class="flex mb-6">
            <a href="{{ route('detection.index', ['show' => 'chart']) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ !request('show') || request('show') == 'chart' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Grafik</a>
            <a href="{{ route('detection.index', ['show' => 'table']) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ request('show') == 'table' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Tabel</a>
        </div>

        @if(!request('show') || request('show') == 'chart')
            <div class="flex flex-col gap-3 w-1/2">
                <h1>Jumlah Sampah Terdeteksi di Area Perairan</h1>
                <div class="bg-slate-400 animate-pulse h-[300px]"></div>
            </div>
        @else
            <table class="w-full">
                <thead>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Jumlah Sampah Terdeteksi</th>
                    <th>Foto</th>
                </thead>
                <tbody>
                    <tr>
                        <td>dd/mm/yyyy hh:mm</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>
                            <div class="w-full flex justify-center">
                                <div class="bg-slate-400 animate-pulse w-[200px] h-[120px]"></div>
                            </div>
                        </td>
                    </tr>
                    <tr class="bg-slate-200">
                        <td>dd/mm/yyyy hh:mm</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>
                            <div class="w-full flex justify-center">
                                <div class="bg-slate-400 animate-pulse w-[200px] h-[120px]"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>dd/mm/yyyy hh:mm</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>
                            <div class="w-full flex justify-center">
                                <div class="bg-slate-400 animate-pulse w-[200px] h-[120px]"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-section-container>
@endsection
