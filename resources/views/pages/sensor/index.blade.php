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
                    <canvas id="tempChart" class="h-[400px]"></canvas>
                </div>
                <div class="flex flex-col gap-3">
                    <h1>Nilai pH Air</h1>
                    <canvas id="phChart" class="h-[400px]"></canvas>
                </div>
                <div class="flex flex-col gap-3">
                    <h1>Tingkat Kekeruhan Air</h1>
                    <canvas id="turbidityChart" class="h-[400px]"></canvas>
                </div>
                <div class="flex flex-col gap-3">
                    <h1>Total Padatan Terlarut Air</h1>
                    <canvas id="tdsChart" class="h-[400px]"></canvas>
                </div>
            </div>

            <script>
                $(document).ready(() => {
                    // Temperature
                    var tempChartCanvas = document.getElementById('tempChart').getContext('2d');
                    var tempChart = new Chart(tempChartCanvas, {
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

                    // pH Value
                    var phChartCanvas = document.getElementById('phChart').getContext('2d');
                    var phChart = new Chart(phChartCanvas, {
                        type: 'line', // Change to 'bar', 'pie', etc. if needed
                        data: {
                            labels: {!! json_encode($labels) !!}, // Time labels
                            datasets: [
                                {
                                    label: 'pH',
                                    data: {!! json_encode($ph) !!},
                                    borderColor: '#4BC0C0',
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

                    // Turbidity
                    var turbidityChartCanvas = document.getElementById('turbidityChart').getContext('2d');
                    var turbidityChart = new Chart(turbidityChartCanvas, {
                        type: 'line', // Change to 'bar', 'pie', etc. if needed
                        data: {
                            labels: {!! json_encode($labels) !!}, // Time labels
                            datasets: [
                                {
                                    label: 'Turbidity (NTU)',
                                    data: {!! json_encode($turbidity) !!},
                                    borderColor: '#FF9F40',
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

                    // Dissolved Solids
                    var tdsChartCanvas = document.getElementById('tdsChart').getContext('2d');
                    var tdsChart = new Chart(tdsChartCanvas, {
                        type: 'line', // Change to 'bar', 'pie', etc. if needed
                        data: {
                            labels: {!! json_encode($labels) !!}, // Time labels
                            datasets: [
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
                });
            </script>
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
                    @forelse($all_sensor_data->reverse() as $sensor_data)
                        <tr class="@if($loop->index % 2 == 0) bg-slate-200 @endif">
                            <td>{{ Carbon\Carbon::parse($sensor_data->date_and_time)->format('d F Y, H:i') }}</td>
                            <td>{{ $sensor_data->temp }}</td>
                            <td>{{ $sensor_data->ph }}</td>
                            <td>{{ $sensor_data->turbidity }}</td>
                            <td>{{ $sensor_data->tds }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">- Data tidak ditemukan -</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </x-section-container>
@endsection
