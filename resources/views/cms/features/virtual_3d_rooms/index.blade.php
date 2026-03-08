@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cms/virtual_3d_rooms.css') }}">
@endpush

@section('breadcrumb_parent', 'CMS / ' . $feature->name)
@section('breadcrumb_active', 'Ruangan Virtual 3D')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ $feature->parent ? route('cms.features.show', $feature->parent) : route('cms.features.index') }}"
                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-white transition-colors shadow-sm" style="background-color: #818284;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Ruangan Virtual 3D &mdash; {{ $feature->name }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola ruangan virtual dengan 4 dinding dan pintu interaktif</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            @if($feature->path)
            <a href="{{ url($feature->path) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-800 border border-transparent text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                Lihat Pameran Virtual
            </a>
            @endif
            <a href="{{ route('cms.features.virtual_3d_rooms.create', $feature) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-800 border border-transparent text-white text-sm font-semibold rounded-lg hover:bg-gray-900 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Ruangan 3D
            </a>
        </div>
    </div>

    @if(session('success'))
    <div x-data="{ open: true }" x-show="open" class="p-4 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        <button x-on:click="open = false" class="text-emerald-500 hover:text-emerald-700 opacity-70 text-lg">&times;</button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm font-medium text-gray-600">Total Ruangan</p>
            <div class="mt-4">
                <h3 class="text-3xl font-bold text-gray-800">{{ $virtual3dRooms->count() }}</h3>
                <p class="text-xs text-gray-500 mt-1">Ruangan virtual 3D aktif</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm font-medium text-gray-600">Total Media</p>
            <div class="mt-4">
                <h3 class="text-3xl font-bold text-gray-800">{{ $virtual3dRooms->sum(fn($r) => $r->media()->count()) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Gambar &amp; video di dinding</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm font-medium text-gray-600">Rata-rata Media</p>
            <div class="mt-4">
                <h3 class="text-3xl font-bold text-gray-800">{{ $virtual3dRooms->count() ? number_format($virtual3dRooms->sum(fn($r) => $r->media()->count()) / $virtual3dRooms->count(), 1) : '0' }}</h3>
                <p class="text-xs text-gray-500 mt-1">Per ruangan</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">Daftar Ruangan Virtual 3D</h2>
        </div>
        <div>
            <table id="tableVirtual3dRooms" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm font-medium border-b border-gray-100">
                        <th class="px-6 py-4 w-12">No</th>
                        <th class="px-6 py-4 w-28">Thumbnail</th>
                        <th class="px-6 py-4">Nama Ruangan</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 w-32">Media</th>
                        <th class="px-6 py-4 w-32 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($virtual3dRooms as $room)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            @if($room->thumbnail_path)
                            <img src="{{ asset('storage/' . $room->thumbnail_path) }}" alt="{{ $room->name }}" class="w-16 h-12 object-cover rounded-md border border-gray-200 shadow-sm">
                            @else
                            <div class="w-16 h-12 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center text-xs text-gray-400">No Img</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-800">{{ $room->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600 line-clamp-2 w-72">{{ $room->description ?: '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                {{ $room->media()->count() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('cms.features.virtual_3d_rooms.edit', [$feature, $room]) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('cms.features.virtual_3d_rooms.destroy', [$feature, $room]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ruangan ini? Semua media di dinding akan ikut terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-md transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                            Belum ada ruangan virtual 3D yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tableVirtual3dRooms').DataTable({
        columnDefs: [{ orderable: false, targets: [0, 1, 5] }],
        order: [[2, 'asc']],
    });
});
</script>
@endpush
