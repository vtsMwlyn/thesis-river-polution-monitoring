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
                <tr>
                    <td>Jumlah Sampah Terdeteksi</td>
                    <td id="popup-garbage">N/A</td>
                </tr>
            </tbody>
        </table>
    </x-popup>
@endsection

@section('content')
    <x-section-container title="Tingkat Pencemaran">
        <div class="flex mb-6">
            <a href="{{ route('polution.index', ['show' => 'chart', 'date' => request('date')]) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ !request('show') || request('show') == 'chart' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Grafik</a>
            <a href="{{ route('polution.index', ['show' => 'table', 'date' => request('date')]) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ request('show') == 'table' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Tabel</a>
        </div>

        @if(!request('show') || request('show') == 'chart')
            <div class="grid grid-cols-2 gap-8">
                <div class="flex flex-col gap-3">
                    <h1>Hasil Pengukuran Sensor</h1>
                    <canvas id="parameterChart" class="h-[400px]"></canvas>
                </div>
                <div class="flex flex-col gap-3">
                    <h1>Jumlah Sampah Terdeteksi</h1>
                    <canvas id="detectionChart" class="h-[400px]"></canvas>
                </div>
                <div class="flex flex-col gap-3">
                    <h1>Kualitas Air</h1>
                    <canvas id="qualityChart" class="h-[400px]"></canvas>
                </div>
            </div>

            <script>
                $(document).ready(() => {
                    // Parameter
                    var parameterChartCanvas = document.getElementById('parameterChart').getContext('2d');
                    var parameterChart = new Chart(parameterChartCanvas, {
                        type: 'line', // Change to 'bar', 'pie', etc. if needed
                        data: {
                            labels: {!! json_encode($labels) !!}, // Time labels
                            datasets: [
                                {
                                    label: 'Temperature (°C)',
                                    data: {!! json_encode($temp) !!},
                                    borderColor: '#FF6384',
                                    // backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderWidth: 2,
                                    // fill: true
                                    pointRadius: 0, // Hide data dots
                                },
                                {
                                    label: 'pH',
                                    data: {!! json_encode($ph) !!},
                                    borderColor: '#4BC0C0',
                                    // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    // fill: true
                                    pointRadius: 0, // Hide data dots
                                },
                                {
                                    label: 'Turbidity (NTU)',
                                    data: {!! json_encode($turbidity) !!},
                                    borderColor: '#FF9F40',
                                    // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    // fill: true
                                    pointRadius: 0, // Hide data dots
                                },
                                {
                                    label: 'Dissolved Solids (ppm)',
                                    data: {!! json_encode($tds) !!},
                                    borderColor: '#9966CC',
                                    // backgroundColor: 'rgba(54, 162, 235, 0.2)',
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

                    // Quality Trend
                    var qualityChartCanvas = document.getElementById('qualityChart').getContext('2d');
                    var qualityChart = new Chart(qualityChartCanvas, {
                        type: 'line', // Change to 'bar', 'pie', etc. if needed
                        data: {
                            labels: {!! json_encode($labels) !!}, // Time labels
                            datasets: [
                                {
                                    label: 'Quality',
                                    data: {!! json_encode($qualities) !!},
                                    borderColor: '#228B22',
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
                                    type: 'category',
                                    labels: ['Excellent', 'Good', 'Moderate', 'Bad', 'Very Bad']
                                }
                            }
                        }
                    });
                })
            </script>
        @else
            <table class="w-full">
                <thead>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Tingkat Pencemaran</th>
                    <th>Detail</th>
                </thead>
                <tbody>
                    @forelse($all_sensor_data->reverse() as $sensor_data)
                        <tr class="@if($loop->index % 2 == 0) bg-slate-200 @endif">
                            <td>{{ Carbon\Carbon::parse($sensor_data->date_and_time)->format('d F Y') }}<br/>{{ Carbon\Carbon::parse($sensor_data->date_and_time)->format('H:i') }}</td>
                            <td>{{ $sensor_data->location ?? 'N/A' }}</td>
                            <td class="font-extrabold">
                                @if($sensor_data->quality == 'Very Bad')
                                    <span class="text-white px-3 py-0.5 rounded-lg bg-red-600">Sangat Buruk</span>
                                @elseif($sensor_data->quality == 'Bad')
                                    <span class="text-white px-3 py-0.5 rounded-lg bg-orange-600">Buruk</span>
                                @elseif($sensor_data->quality == 'Moderate')
                                    <span class="text-white px-3 py-0.5 rounded-lg bg-yellow-600">Sedang</span>
                                @elseif($sensor_data->quality == 'Good')
                                    <span class="text-white px-3 py-0.5 rounded-lg bg-green-700">Baik</span>
                                @elseif($sensor_data->quality == 'Excellent')
                                    <span class="text-white px-3 py-0.5 rounded-lg bg-blue-600">Sangat Baik</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="show-water-quality-parameters inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg" data-water_parameters="{{ $sensor_data }}" data-detections="{{ App\Models\GarbageDetection::where('date_and_time', 'like', Carbon\Carbon::parse($sensor_data->date_and_time)->format('Y-m-d H:i') . '%')->first() }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">- Data tidak ditemukan -</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <script>
                $(document).ready(() => {
                    // Popup display
                    $('.show-water-quality-parameters').on('click', function(){
                        const waterParameters = $(this).data('water_parameters');
                        const garbageDetection = $(this).data('detections');

                        $('#popup-temp').text(waterParameters.temp);
                        $('#popup-ph').text(waterParameters.ph);
                        $('#popup-turbidity').text(waterParameters.turbidity);
                        $('#popup-tds').text(waterParameters.tds);
                        $('#popup-garbage').text(garbageDetection?.number)

                        $('#water-quality-parameters-popup').parent().show();
                    });
                });
            </script>
        @endif
    </x-section-container>
@endsection
