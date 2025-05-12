<x-guest-layout>
    <div class="w-full flex gap-8">
        <x-section-container title="Send Sensor Data" class="w-1/2">
            <form action="http://192.168.1.4/web-application-system/public/api/send-sensor-data" method="post">
                <input type="hidden" name="secret" value="VTS_Meowlynna-2312">
                <button class="inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg">Call API</button>
            </form>
        </x-section-container>

        <x-section-container title="Send Detection Data" class="w-1/2">
            <form action="http://192.168.1.4/web-application-system/public/api/send-detection-data" method="post">
                <input type="hidden" name="secret" value="VTS_Meowlynna-2312">
                <button class="inline-block bg-cyan-900 hover:bg-slate-600 text-white py-1 px-2.5 rounded-lg">Call API</button>
            </form>
        </x-section-container>
    </div>
</x-guest-layout>
