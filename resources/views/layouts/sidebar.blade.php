<div class="w-1/6 h-screen text-white font-semibold flex flex-col sticky top-0 bg-gradient-to-b from-cyan-900 to-cyan-800">
    <a href="{{ route('dashboard') }}" class="mt-20 block px-6 py-3 {{ Request::is('dashboard*') ? 'bg-cyan-600' : 'hover:bg-cyan-800' }}">
        <i class="bi bi-grid-fill mr-2"></i> Dashboard
    </a>
    <a href="{{ route('sensor.index') }}" class="block px-6 py-3 {{ Request::is('sensor*') ? 'bg-cyan-600' : 'hover:bg-cyan-800' }}">
        <i class="bi bi-water mr-2"></i> Pengukuran Kualitas Air
    </a>
    <a href="{{ route('detection.index') }}" class="block px-6 py-3 {{ Request::is('detection*') ? 'bg-cyan-600' : 'hover:bg-cyan-800' }}">
        <i class="bi bi-bounding-box-circles mr-2"></i> Deteksi Sampah
    </a>
    <a href="{{ route('polution.index') }}" class="block px-6 py-3 {{ Request::is('polution*') ? 'bg-cyan-600' : 'hover:bg-cyan-800' }}">
        <i class="bi bi-graph-up mr-2"></i> Tingkat Pencemaran
    </a>
</div>
