@extends('layouts.app')

@section('popup')
    <x-popup title="Tentang Suhu" class="w-1/3 text-justify" id="temp-info-popup">
        <p class="mb-4">Suhu merupakan salah satu parameter yang mempengaruhi dalam penentuan kualitas air dengan tingkat pengaruh sebesar <b>10%</b> dalam perhitungan indeks kualitas air National Sanitation Foundation. Menurut WHO, suhu yang tergolong baik adalah antara <b>12-25 derajat Celcius</b>.</p>

        <p>Suhu akan mempengaruhi daya terima sejumlah unsur anorganik dan kontaminan kimia lainnya yang dapat mempengaruhi rasa. Suhu air yang tinggi dapat meningkatkan pertumbuhan mikroorganisme dan dapat meningkatkan masalah yang berkaitan dengan rasa, bau, warna, dan korosi. (Quinn, 2013).</p>
    </x-popup>

    <x-popup title="Tentang Nilai PH" class="w-1/3 text-justify" id="ph-info-popup">
        <p class="mb-4">Nilai pH merupakan salah satu parameter yang mempengaruhi dalam penentuan kualitas air dengan tingkat pengaruh sebesar <b>11%</b> dalam perhitungan indeks kualitas air National Sanitation Foundation. Menurut WHO, suhu yang tergolong baik adalah antara <b>6,5-8,5</b>.</p>

        <p>PH dari zat adalah ukuran tingkat keasaman, serupa dengan derajat yang merupakan ukuran dari suhu. (Wescott, 2022). Perhatian yang cermat terhadap kontrol pH diperlukan pada semua tahap pengolahan air untuk memastikan pemurnian dan disinfeksi air yang baik juga meminimalisasi korosi pada pipa utama dan sistem air lainnya untuk mencegah kontaminasi pada air dan efek buruk pada rasa dan penampilannya. (WHO, 2022).</p>
    </x-popup>

    <x-popup title="Tentang Tingkat Kekeruhan" class="w-1/3 text-justify" id="turbidity-info-popup">
        <p class="mb-4">Tingkat kekeruhan atau turbidity merupakan salah satu parameter yang mempengaruhi dalam penentuan kualitas air dengan tingkat pengaruh sebesar <b>8%</b> dalam perhitungan indeks kualitas air National Sanitation Foundation. Menurut WHO, nilai turbidity yang tergolong baik adalah antara <b>1-5 NTU</b>.</p>

        <p>Turbidity adalah seberapa keruh air yang disebabkan oleh partikel yang tersuspensi, endapan kimia, partikel organik, atau organisme. Kekeruhan sendiri bisa disebabkan oleh kualitas sumber air yang buruk, pengolahan yang buruk, adanya gangguan sedimen dan biofilm, atau masuknya air kotor dari kerusakan utama atau penyebab lainnya. (WHO, 2022).</p>
    </x-popup>

    <x-popup title="Tentang Jumlah Padatan Terlarut" class="w-1/3 text-justify" id="tds-info-popup">
        <p class="mb-4">Jumlah padatan terlarut atau Total Dissolved Solids (TDS) merupakan salah satu parameter yang mempengaruhi dalam penentuan kualitas air dengan tingkat pengaruh sebesar <b>8%</b> dalam perhitungan indeks kualitas air National Sanitation Foundation. Menurut WHO, nilai TDS yang tergolong baik adalah di bawah <b>600 ppm</b>.</p>

        <p>TDS mengacu pada jumlah total substansi organik dan anorganik yang terdiri dari kation (seperti kalsium, magnesium, potasium, dan sodium) dan anion (seperti karbonat, nitrat, bikarbonat, klorida, dan sulfat). Adanya substansi organik dan anorganik tersebut dapat disebabkan karena pembuangan limbah domestik dan industri yang tidak diolah atau limbah perkotaan dan/atau pertanian yang tidak dibuang secara sembarangan dan berada dalam bentuk mikro atau nano di perairan. (Pushpalatha, N., 2022).</p>
    </x-popup>
@endsection

@section('content')
    <x-section-container title="Pengukuran Sensor">
        <div class="flex mb-6">
            <a href="{{ route('sensor.index', ['show' => 'chart']) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ !request('show') || request('show') == 'chart' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Grafik</a>
            <a href="{{ route('sensor.index', ['show' => 'table']) }}" class="inline-block w-[150px] text-center px-4 h-8 border-b-4 {{ request('show') == 'table' ? 'border-cyan-600' : 'border-transparent hover:border-slate-300' }}">Tampilan Tabel</a>
        </div>

        @if(!request('show') || request('show') == 'chart')
            <div class="grid grid-cols-2 gap-8">
                <div class="flex flex-col gap-3">
                    <div class="flex gap-3 items-center">
                        <h1>Suhu Air</h1>
                        <button type="button" id="show-temp-info-btn" class="inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg"><i class="bi bi-info-circle"></i></button>
                    </div>
                    <canvas id="tempChart" class="h-[400px]"></canvas>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="flex gap-3 items-center">
                        <h1>Nilai pH Air</h1>
                        <button type="button" id="show-ph-info-btn" class="inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg"><i class="bi bi-info-circle"></i></button>
                    </div>
                    <canvas id="phChart" class="h-[400px]"></canvas>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="flex gap-3 items-center">
                        <h1>Tingkat Kekeruhan Air</h1>
                        <button type="button" id="show-turbidity-info-btn" class="inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg"><i class="bi bi-info-circle"></i></button>
                    </div>
                    <canvas id="turbidityChart" class="h-[400px]"></canvas>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="flex gap-3 items-center">
                        <h1>Jumlah Padatan Terlarut Air</h1>
                        <button type="button" id="show-tds-info-btn" class="inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg"><i class="bi bi-info-circle"></i></button>
                    </div>
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
                                },
                                {
                                    label: 'Batas atas standar WHO',
                                    data: Array({!! json_encode(count($temp)) !!}).fill(25),
                                    borderColor: 'green',
                                    // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 1,
                                    // fill: true
                                    pointRadius: 0, // Hide data dots
                                    pointHoverRadius: 0,
                                    tooltip: {
                                        enabled: false
                                    },
                                    segment: {
                                        borderDash: [5, 5] // Optional: dashed line for visual distinction
                                    },
                                },
                                {
                                    label: 'Batas aman standar WHO',
                                    data: Array({!! json_encode(count($temp)) !!}).fill(12),
                                    borderColor: 'green',
                                    borderWidth: 1,
                                    fill: '-1',
                                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                                    pointRadius: 0, // Hide data dots
                                    pointHoverRadius: 0,
                                    tooltip: {
                                        enabled: false
                                    },
                                    segment: {
                                        borderDash: [5, 5] // Optional: dashed line for visual distinction
                                    },
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
                                },
                                {
                                    label: 'Batas atas standar WHO',
                                    data: Array({!! json_encode(count($ph)) !!}).fill(8.5),
                                    borderColor: 'green',
                                    // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 1,
                                    // fill: true
                                    pointRadius: 0, // Hide data dots
                                    pointHoverRadius: 0,
                                    tooltip: {
                                        enabled: false
                                    },
                                    segment: {
                                        borderDash: [5, 5] // Optional: dashed line for visual distinction
                                    },
                                },
                                {
                                    label: 'Batas bawah standar WHO',
                                    data: Array({!! json_encode(count($ph)) !!}).fill(6.5),
                                    borderColor: 'green',
                                    borderWidth: 1,
                                    fill: '-1',
                                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                                    pointRadius: 0, // Hide data dots
                                    pointHoverRadius: 0,
                                    tooltip: {
                                        enabled: false
                                    },
                                    segment: {
                                        borderDash: [5, 5] // Optional: dashed line for visual distinction
                                    },
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
                                },
                                {
                                    label: 'Batas atas standar WHO',
                                    data: Array({!! json_encode(count($turbidity)) !!}).fill(5),
                                    borderColor: 'green',
                                    // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 1,
                                    // fill: true
                                    pointRadius: 0, // Hide data dots
                                    pointHoverRadius: 0,
                                    tooltip: {
                                        enabled: false
                                    },
                                    segment: {
                                        borderDash: [5, 5] // Optional: dashed line for visual distinction
                                    },
                                },
                                {
                                    label: 'Batas bawah standar WHO',
                                    data: Array({!! json_encode(count($turbidity)) !!}).fill(1),
                                    borderColor: 'green',
                                    borderWidth: 1,
                                    fill: '-1',
                                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                                    pointRadius: 0, // Hide data dots
                                    pointHoverRadius: 0,
                                    tooltip: {
                                        enabled: false
                                    },
                                    segment: {
                                        borderDash: [5, 5] // Optional: dashed line for visual distinction
                                    },
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
                                    label: 'Total Dissolved Solids (ppm)',
                                    data: {!! json_encode($tds) !!},
                                    borderColor: '#9966CC',
                                    // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    // fill: true
                                    pointRadius: 0, // Hide data dots
                                },
                                {
                                    label: 'Batas maksimum standar WHO',
                                    data: Array({!! json_encode(count($tds)) !!}).fill(600),
                                    borderColor: 'green',
                                    borderWidth: 1,
                                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                                    fill: true,
                                    pointRadius: 0, // Hide data dots
                                    pointHoverRadius: 0,
                                    tooltip: {
                                        enabled: false
                                    },
                                    segment: {
                                        borderDash: [5, 5] // Optional: dashed line for visual distinction
                                    },
                                },
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

                    $('#show-temp-info-btn').on('click', () => {
                        $('#temp-info-popup').parent().show();
                    });

                    $('#show-ph-info-btn').on('click', () => {
                        $('#ph-info-popup').parent().show();
                    });

                    $('#show-turbidity-info-btn').on('click', () => {
                        $('#turbidity-info-popup').parent().show();
                    });

                    $('#show-tds-info-btn').on('click', () => {
                        $('#tds-info-popup').parent().show();
                    });
                });
            </script>
        @else
            <table class="w-full">
                <thead>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Suhu</th>
                    <th>pH</th>
                    <th>Kekeruhan</th>
                    <th>Padatan Terlarut</th>
                    @if(Auth::id() == 2)
                        <th>Action</th>
                    @endif
                </thead>
                <tbody>
                    @forelse($all_sensor_data->reverse() as $sensor_data)
                        <tr class="@if($loop->index % 2 == 0) bg-slate-200 @endif">
                            <td>{{ Carbon\Carbon::parse($sensor_data->date_and_time)->format('d F Y, H:i') }}</td>
                            <td>{{ $sensor_data->location ?? 'N/A' }}</td>
                            <td>{{ $sensor_data->temp }}</td>
                            <td>{{ $sensor_data->ph }}</td>
                            <td>{{ $sensor_data->turbidity }}</td>
                            <td>{{ $sensor_data->tds }}</td>
                            @if(Auth::id() == 2)
                                <td>
                                    <form action="{{ route('sensor.destroy', $sensor_data->id) }}" method="post">
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
                            <td colspan="5">- Data tidak ditemukan -</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </x-section-container>
@endsection
