@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-6 gap-x-8">
        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-thermometer-low text-4xl text-blue-800"></i>
            <h1 class="text-center">Suhu</h1>
            <h1 class="text-2xl text-center font-extrabold" id="temp">N/A</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-reception-2 text-4xl text-blue-800"></i>
            <h1 class="text-center">Nilai pH</h1>
            <h1 class="text-2xl text-center font-extrabold" id="ph">N/A</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-droplet-half text-4xl text-blue-800"></i>
            <h1 class="text-center">Kekeruhan</h1>
            <h1 class="text-2xl text-center font-extrabold" id="turbidity">N/A</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-ui-radios-grid text-4xl text-blue-800"></i>
            <h1 class="text-center">Padatan Terlarut</h1>
            <h1 class="text-2xl text-center font-extrabold" id="tds">N/A</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-trash2 text-4xl text-blue-800"></i>
            <h1 class="text-center">Deteksi Sampah</h1>
            <h1 class="text-2xl text-center font-extrabold" id="garbage">N/A</h1>
        </x-section-container>

        <x-section-container class="flex flex-col items-center gap-2">
            <i class="bi bi-stars text-4xl text-blue-800"></i>
            <h1 class="text-center">Kualitas Air</h1>
            <span class="text-white px-3 py-0.5 text-lg font-extrabold rounded-lg bg-slate-600" id="quality">N/A</span>
        </x-section-container>
    </div>

    <div class="flex mt-8 space-x-8">
        <x-section-container title="Pemantauan Terkini" class="w-3/5">
            <!-- Placeholder -->
            <div class="w-full flex justify-center" id="photo">
                <div class="bg-slate-400 animate-pulse h-[400px] w-full"></div>
            </div>
        </x-section-container>

        <x-section-container title="Peringatan" class="w-2/5">
            <div class="max-h-[400px] overflow-y-auto" id="warnings">
                <div class="bg-slate-400 animate-pulse h-[400px] w-full"></div>
            </div>
        </x-section-container>
    </div>

    <script>
        const fetchLatestData = () => {
            $.get('{{ route("latest-data") }}', function(response) {
                console.log('Data successfully retrieved!');

                const { all_warnings, latest_detection, latest_sensor_data } = response;

                $('#temp').text(latest_sensor_data.temp);
                $('#ph').text(latest_sensor_data.ph);
                $('#turbidity').text(latest_sensor_data.turbidity);
                $('#tds').text(latest_sensor_data.tds);
                $('#garbage').text(latest_detection.number);

                const kualiti = latest_sensor_data.quality;
                let badge_color = 'bg-slate-600';

                switch(kualiti){
                    case 'Very Bad': badge_color = 'bg-red-600'; break;
                    case 'Bad': badge_color = 'bg-orange-600'; break;
                    case 'Moderate': badge_color = 'bg-yellow-600'; break;
                    case 'Good': badge_color = 'bg-green-600'; break;
                    case 'Excellent': badge_color = 'bg-blue-600'; break;
                }
                $('#quality').removeClass('bg-slate-600').addClass(badge_color).text(kualiti);

                $('#photo').html(`<img src="${latest_detection.photo}" class="w-full h-[400px] object-cover" />`)

                $('#warnings').html('');
                all_warnings.forEach(warning => {
                    let border_color = 'border-slate-600';
                    let warning_badge_color = 'bg-slate-600';
                    let translated_status = 'status';

                    if(warning.category == 'Bad'){
                        border_color = 'border-orange-600';
                        warning_badge_color = 'bg-orange-600';
                        translated_status = 'Buruk';
                    }
                    else if(warning.catgory == 'Very Bad'){
                        border_color = 'border-red-600';
                        warning_badge_color = 'bg-red-600';
                        translated_status = 'Sangat Buruk';
                    }

                    $('#warnings').append(
                        $('<div>').addClass(`mb-8 px-4 py-2 bg-white shadow-md border-l-4 ${border_color}`)
                            .append(
                                $('<div>').addClass('w-full flex justify-between items-center mb-4')
                                    .append(
                                        $('<h1>').addClass('font-extrabold text-blue-900').text(warning.date_and_time)
                                    ).append(
                                        $('<span>').addClass(`text-white px-3 py-0.5 rounded-lg ${warning_badge_color}`).html(`<i class="bi bi-exclamation-triangle-fill"></i> ${translated_status}`)
                                    )
                            )
                            .append(
                                $('<div>').html(warning.message)
                            )
                    )
                });
            });
        }

        $(document).ready(() => {
            setInterval(() => {
                fetchLatestData();
            }, 10000);

            fetchLatestData();
        });
    </script>
@endsection
