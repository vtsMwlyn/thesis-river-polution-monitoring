@extends('layouts.app')

@section('content')
    <x-section-container title="Deteksi Sampah">
        <div class="flex mb-6">
            <a href="{{ route('detection.index', ['show' => 'chart', 'date' => request('date')]) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ !request('show') || request('show') == 'chart' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Grafik</a>
            <a href="{{ route('detection.index', ['show' => 'table', 'date' => request('date')]) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ request('show') == 'table' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Tabel</a>
        </div>

        @if(!request('show') || request('show') == 'chart')
            <div class="flex flex-col gap-3 w-1/2">
                <h1>Jumlah Sampah Terdeteksi di Area Perairan</h1>
                <canvas id="detectionChart" class="h-[400px]"></canvas>
            </div>

            <script>
                // Detections
                var detectionChartCanvas = document.getElementById('detectionChart').getContext('2d');
                var detectionChart = new Chart(detectionChartCanvas, {
                    type: 'line', // Change to 'bar', 'pie', etc. if needed
                    data: {
                        labels: {!! json_encode($labels) !!}, // Time labels
                        datasets: [
                            {
                                label: 'Numbers of Garbage',
                                data: {!! json_encode($garbage_detected) !!},
                                borderColor: 'blue',
                                // backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderWidth: 2,
                                // fill: true
                                pointRadius: 0, // Hide data dots
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: false
                            }
                        }
                    }
                });
            </script>
        @else
            <table class="w-full">
                <thead>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Jumlah Sampah Terdeteksi</th>
                    <th>Foto</th>
                    @if(Auth::id() == 2)
                        <th>Action</th>
                    @endif
                </thead>
                <tbody>
                    @forelse ($all_detections->reverse() as $detection)
                        <tr class="@if($loop->index % 2 == 0) bg-slate-200 @endif">
                            <td>{{ Carbon\Carbon::parse($detection->date_and_time)->format('d F Y') }} <br/> {{ Carbon\Carbon::parse($detection->date_and_time)->format('H:i') }}</td>
                            <td>{{ $detection->location ?? 'N/A' }}</td>
                            <td>{{ $detection->number }}</td>
                            <td>
                                <div class="w-full flex justify-center">
                                    <img src="{{ Storage::url('app/public/' . $detection->image_path) }}" class="h-[250px]" alt="Detection photo" loading="lazy">
                                </div>
                            </td>
                            @if(Auth::id() == 2)
                                <td>
                                    <form action="{{ route('detection.destroy', $detection->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="show-water-quality-parameters inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg" onclick="return confirm('Are you sure want to delete this item?');">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">- Data tidak ditemukan -</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </x-section-container>
@endsection
