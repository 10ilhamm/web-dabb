@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/cms/virtual_3d_rooms.css') }}">
<style>
/* 3D Preview styles */
.room3d-preview-wrap {
    perspective: 800px;
    width: 100%;
    height: 500px;
    overflow: hidden;
    background: #1e293b;
    border-radius: 12px;
    position: relative;
}

.room3d-scene {
    width: 260px;
    height: 200px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform-style: preserve-3d;
    transform: translate(-50%, -50%) rotateX(-10deg) rotateY(-25deg);
    transition: transform 0.6s ease;
}

.room3d-face {
    position: absolute;
    left: 50%;
    top: 50%;
    border: 1px solid rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    color: rgba(255,255,255,0.5);
    font-weight: 600;
    letter-spacing: 0.05em;
    backface-visibility: visible;
}

.room3d-face.front  { width: 260px; height: 200px; transform: translate(-50%, -50%) translateZ(-130px); }
.room3d-face.back   { width: 260px; height: 200px; transform: translate(-50%, -50%) translateZ(130px) rotateY(180deg); }
.room3d-face.left   { width: 260px; height: 200px; transform: translate(-50%, -50%) translateX(-130px) rotateY(90deg); }
.room3d-face.right  { width: 260px; height: 200px; transform: translate(-50%, -50%) translateX(130px) rotateY(-90deg); }
.room3d-face.floor  { width: 260px; height: 260px; transform: translate(-50%, -50%) translateY(100px) rotateX(90deg); }
.room3d-face.ceiling{ width: 260px; height: 260px; transform: translate(-50%, -50%) translateY(-100px) rotateX(-90deg); }

.room3d-door {
    position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
    width: 40px; height: 80px; background: rgba(100,116,139,0.5);
    border: 1px solid rgba(255,255,255,0.3); border-bottom: none;
    border-radius: 4px 4px 0 0; display: flex; align-items: center;
    justify-content: center; font-size: 8px; color: rgba(255,255,255,0.7);
}
.room3d-door-knob {
    width: 4px; height: 4px; border-radius: 50%; background: rgba(255,255,255,0.5);
    position: absolute; right: 6px; top: 50%;
}

.preview-rot-btn {
    padding: 4px 10px; font-size: 11px; background: rgba(255,255,255,0.1);
    color: #e2e8f0; border: 1px solid rgba(255,255,255,0.15);
    border-radius: 4px; cursor: pointer; transition: background 0.15s;
}
.preview-rot-btn:hover { background: rgba(255,255,255,0.2); }
.preview-rot-btn.active { background: #3b82f6; border-color: #3b82f6; color: white; }
</style>
@endpush

@section('breadcrumb_parent', 'CMS / Ruangan Virtual 3D')
@section('breadcrumb_active', 'Edit: ' . $room->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('cms.features.virtual_3d_rooms.index', $feature) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-white text-sm font-medium transition-colors shadow-sm" style="background-color: #818284;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Daftar Ruangan
    </a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Ruangan: {{ $room->name }}</h1>
    <p class="text-sm text-gray-500 mt-1">Atur informasi ruangan, warna, media dinding, dan hotspot navigasi</p>
</div>

@if(session('success'))
<div x-data="{ open: true }" x-show="open" class="mb-6 p-4 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-between">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    <button x-on:click="open = false" class="text-emerald-500 hover:text-emerald-700 opacity-70 text-lg">&times;</button>
</div>
@endif

<form action="{{ route('cms.features.virtual_3d_rooms.update', [$feature, $room]) }}" method="POST" enctype="multipart/form-data" id="virtual3d-room-form">
    @csrf
    @method('PUT')
    <input type="hidden" name="auto_thumbnail" id="autoThumbnailInput">

    <div class="flex gap-6 items-start" style="flex-wrap: nowrap;">

        <!-- Left Column: Form, Colors, Media, Hotspot -->
        <div class="space-y-6" style="width: 38%; min-width: 350px; flex-shrink: 0;">

            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Informasi Ruangan</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ruangan <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $room->name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $room->description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Ruangan</label>
                        @if($room->thumbnail_path)
                            <img src="{{ asset('storage/' . $room->thumbnail_path) }}" class="mt-1 mb-2 w-full h-24 object-cover rounded-lg border border-gray-200">
                        @endif
                        <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1.5">Biarkan kosong jika tidak ingin mengubah</p>
                    </div>
                </div>
            </div>

            <!-- Room Colors -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Warna Ruangan</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna Dinding</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="wall_color" id="wallColorInput" value="{{ old('wall_color', $room->wall_color) }}" class="w-10 h-10 p-1 border border-gray-300 rounded-lg cursor-pointer" onchange="updatePreviewColors()">
                            <input type="text" id="wallColorText" value="{{ old('wall_color', $room->wall_color) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna Lantai</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="floor_color" id="floorColorInput" value="{{ old('floor_color', $room->floor_color) }}" class="w-10 h-10 p-1 border border-gray-300 rounded-lg cursor-pointer" onchange="updatePreviewColors()">
                            <input type="text" id="floorColorText" value="{{ old('floor_color', $room->floor_color) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna Atap</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="ceiling_color" id="ceilingColorInput" value="{{ old('ceiling_color', $room->ceiling_color) }}" class="w-10 h-10 p-1 border border-gray-300 rounded-lg cursor-pointer" onchange="updatePreviewColors()">
                            <input type="text" id="ceilingColorText" value="{{ old('ceiling_color', $room->ceiling_color) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Door / Hotspot -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5" x-data="{ doorType: '{{ old('door_link_type', $room->door_link_type) }}' }">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">Pengaturan Pintu / Hotspot</h3>
                <p class="text-xs text-gray-500 mb-4">Pintu di dinding belakang untuk navigasi ke halaman/ruangan lain</p>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Tautan Pintu</label>
                        <select name="door_link_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" x-model="doorType">
                            <option value="none">Tidak Aktif (Hanya Visual)</option>
                            <option value="room">Arahkan ke Ruangan Lain</option>
                            <option value="url">Tautan Bebas (URL)</option>
                        </select>
                    </div>

                    <div x-show="doorType === 'room'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Target Ruangan</label>
                        <select x-bind:name="doorType === 'room' ? 'door_target' : ''" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">— Pilih Ruangan —</option>
                            @foreach($allRooms as $r)
                            <option value="{{ $r->id }}" {{ $room->door_target == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="doorType === 'url'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Target URL</label>
                        <input type="text" x-bind:name="doorType === 'url' ? 'door_target' : ''" value="{{ old('door_target', $room->door_target) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="https://...">
                    </div>

                    <div x-show="doorType !== 'none'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Label Pintu (Opsional)</label>
                        <input type="text" name="door_label" value="{{ old('door_label', $room->door_label) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="Contoh: KELUAR">
                    </div>
                </div>
            </div>

            <!-- Media Dinding -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-800">Media Dinding (Foto / Video)</h3>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $room->media()->count() }} item</span>
                </div>

                <div id="uploadMediaSection">
                    <div class="space-y-3 mb-4">
                        {{-- Wall indicator synced from wall editor tabs --}}
                        <input type="hidden" id="uploadWall" value="front">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Dinding Terpilih</label>
                            <div id="uploadWallBadge" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold text-white" style="background-color: #1e40af;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                <span id="uploadWallLabel">Dinding Depan</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Pilih dinding di panel <strong>Editor Posisi Media</strong> di sebelah kanan</p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tipe Media</label>
                            <select id="uploadType" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="image">Gambar (JPG/PNG)</option>
                                <option value="video">Video (MP4)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">File Upload</label>
                            <input id="uploadFile" type="file" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" accept="image/*,video/mp4,video/webm">
                        </div>
                    </div>

                    <button type="button" onclick="uploadNewMedia()" class="w-full text-sm font-semibold text-white px-4 py-2.5 rounded-lg flex items-center justify-center gap-2 transition-colors" style="background-color: #1e3a5f;" onmouseover="this.style.backgroundColor='#162d4a'" onmouseout="this.style.backgroundColor='#1e3a5f'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Unggah &amp; Tambah ke Dinding
                    </button>
                </div>

                <!-- List of uploaded media -->
                <div id="mediaList" class="mt-4 space-y-2">
                    @forelse($room->media as $media)
                    <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg border border-gray-100 media-list-item" data-id="{{ $media->id }}">
                        <div class="w-12 h-10 flex-shrink-0 rounded overflow-hidden bg-gray-200">
                            @if($media->type === 'image')
                            <img src="{{ asset('storage/'.$media->file_path) }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-800 truncate">{{ ucfirst($media->type) }} #{{ $media->id }}</p>
                            <p class="text-xs text-gray-500">Dinding: {{ ucfirst($media->wall) }}</p>
                        </div>
                        <button type="button" onclick="deleteMediaItem({{ $media->id }}, this)" class="p-1.5 text-red-500 hover:bg-red-50 rounded transition-colors" title="Hapus">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    @empty
                    <div id="noMediaMsg" class="text-center py-4 text-sm text-gray-400 border-2 border-dashed border-gray-100 rounded-lg">
                        Belum ada media. Unggah file di atas.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right Column: 3D Preview + Wall Editor -->
        <div class="w-full space-y-6" style="width: 62%;">

            <!-- 3D Preview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Preview Ruangan 3D</h3>
                <p class="text-xs text-gray-500 mb-4">Preview langsung ruangan sesuai pengaturan warna Anda</p>

                <div class="room3d-preview-wrap" id="preview3dContainer">
                    <div class="room3d-scene" id="preview3dScene">
                        <div class="room3d-face front" id="pv-wall-front">DEPAN</div>
                        <div class="room3d-face back" id="pv-wall-back">
                            BELAKANG
                            <div class="room3d-door" id="pv-door">
                                <span>PINTU</span>
                                <div class="room3d-door-knob"></div>
                            </div>
                        </div>
                        <div class="room3d-face left" id="pv-wall-left">KIRI</div>
                        <div class="room3d-face right" id="pv-wall-right">KANAN</div>
                        <div class="room3d-face floor" id="pv-floor">LANTAI</div>
                        <div class="room3d-face ceiling" id="pv-ceiling">ATAP</div>
                    </div>

                    <div style="position:absolute; bottom:12px; left:50%; transform:translateX(-50%); display:flex; gap:6px; z-index:10;">
                        <button type="button" class="preview-rot-btn active" onclick="rotatePreview('default', this)">Default</button>
                        <button type="button" class="preview-rot-btn" onclick="rotatePreview('front', this)">Depan</button>
                        <button type="button" class="preview-rot-btn" onclick="rotatePreview('left', this)">Kiri</button>
                        <button type="button" class="preview-rot-btn" onclick="rotatePreview('right', this)">Kanan</button>
                        <button type="button" class="preview-rot-btn" onclick="rotatePreview('back', this)">Belakang</button>
                        <button type="button" class="preview-rot-btn" onclick="rotatePreview('top', this)">Atas</button>
                    </div>
                </div>
            </div>

            <!-- Wall Editor (Drag & Reposition) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Editor Posisi Media di Dinding</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Geser media untuk mengatur posisi di dinding. Klik media untuk menampilkan properti.</p>
                    </div>
                </div>
                <div class="mb-4 flex flex-wrap gap-2">
                    <button type="button" onclick="switchWallView('front')" data-wall="front" class="wall-tab-btn active">Dinding Depan</button>
                    <button type="button" onclick="switchWallView('left')" data-wall="left" class="wall-tab-btn">Dinding Kiri</button>
                    <button type="button" onclick="switchWallView('right')" data-wall="right" class="wall-tab-btn">Dinding Kanan</button>
                    <button type="button" onclick="switchWallView('back')" data-wall="back" class="wall-tab-btn">Dinding Belakang</button>
                </div>

                <div id="wallEditor" class="wall-panel" style="background-color: {{ $room->wall_color }}">
                    <div class="wall-panel-title" id="wallTitleLabel">DINDING DEPAN</div>
                    <div id="doorRender" class="door-rendered" style="display: none;" data-active="{{ $room->door_link_type !== 'none' ? '1' : '0' }}">
                        <div class="text-center">PINTU<br><span class="text-xs opacity-70">{{ $room->door_label ?: 'KELUAR' }}</span></div>
                    </div>
                </div>

                <!-- Properties Panel -->
                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200" id="propertiesPanel" style="display: none;">
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-xs font-semibold text-gray-700">Properti Media yang Dipilih</p>
                        <button type="button" onclick="deleteActiveMedia()" class="text-xs text-red-600 font-semibold hover:text-red-700">Hapus</button>
                    </div>
                    <div class="grid grid-cols-4 gap-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">X (%)</label>
                            <input type="number" id="propX" step="any" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs" onchange="updatePropertiesFromInput()">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Y (%)</label>
                            <input type="number" id="propY" step="any" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs" onchange="updatePropertiesFromInput()">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">W (%)</label>
                            <input type="number" id="propW" step="any" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs" onchange="updatePropertiesFromInput()">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">H (%)</label>
                            <input type="number" id="propH" step="any" class="w-full px-2 py-1.5 border border-gray-300 rounded text-xs" onchange="updatePropertiesFromInput()">
                        </div>
                    </div>
                    <button type="button" onclick="saveActiveMedia()" class="mt-3 w-full text-sm font-semibold text-white px-3 py-2 rounded-lg transition-colors" style="background-color:#1d4ed8;">Simpan Posisi</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Sticky Footer Actions -->
    <div class="mt-8 flex justify-end gap-3 pb-8">
        <a href="{{ route('cms.features.virtual_3d_rooms.index', $feature) }}" class="px-5 py-2.5 bg-gray-100 border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 active:bg-gray-300 transition-colors shadow-sm">
            Batal
        </a>
        <button type="submit" id="saveRoomBtn" class="px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm flex items-center gap-2" style="background-color:#1d4ed8;" onmouseover="this.style.backgroundColor='#1e40af'" onmouseout="this.style.backgroundColor='#1d4ed8'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
            Simpan Perubahan
        </button>
    </div>
</form>

{{-- Room media data for JS wall editor --}}
<script type="application/json" id="roomMediaData">@json($room->media)</script>
@endsection

@push('scripts')
<!-- Add html2canvas for automatic room thumbnail generation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    const saveBtn = document.getElementById('saveRoomBtn');
    if(saveBtn) {
        saveBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('virtual3d-room-form');
            const previewContainer = document.getElementById('preview3dContainer');
            
            // Only generate if no file was selected manually
            const fileInput = document.querySelector('input[name="thumbnail"]');
            if (fileInput && fileInput.files.length === 0 && previewContainer) {
                // Briefly reset perspective to default for a clear screenshot
                const oldTransform = previewContainer.style.transform;
                previewContainer.style.transform = 'none';
                
                html2canvas(previewContainer, {
                    backgroundColor: '#000000',
                    useCORS: true,
                    logging: false
                }).then(canvas => {
                    previewContainer.style.transform = oldTransform;
                    document.getElementById('autoThumbnailInput').value = canvas.toDataURL('image/jpeg', 0.8);
                    form.submit();
                }).catch(err => {
                    form.submit(); // fallback
                });
            } else {
                form.submit();
            }
        });
    }

    // Global routes used by virtual_3d_rooms.js functions
    window.v3dCsrf = '{{ csrf_token() }}';
    window.v3dRoutes = {
        upload: "{{ route('cms.features.virtual_3d_rooms.media.store', [$feature, $room]) }}",
        updateMedia: "{{ route('cms.features.virtual_3d_rooms.media.update', [$feature, $room, '__MEDIA_ID__']) }}",
        deleteMedia: "{{ route('cms.features.virtual_3d_rooms.media.destroy', [$feature, $room, '__MEDIA_ID__']) }}"
    };

    // Update preview colors
    function updatePreviewColors() {
        const wc = document.getElementById('wallColorInput').value;
        const fc = document.getElementById('floorColorInput').value;
        const cc = document.getElementById('ceilingColorInput').value;
        document.getElementById('wallColorText').value = wc;
        document.getElementById('floorColorText').value = fc;
        document.getElementById('ceilingColorText').value = cc;
        document.getElementById('pv-wall-front').style.backgroundColor = wc;
        document.getElementById('pv-wall-back').style.backgroundColor = wc;
        document.getElementById('pv-wall-left').style.backgroundColor = wc;
        document.getElementById('pv-wall-right').style.backgroundColor = wc;
        document.getElementById('pv-floor').style.backgroundColor = fc;
        document.getElementById('pv-ceiling').style.backgroundColor = cc;
        const wallEditor = document.getElementById('wallEditor');
        if (wallEditor) wallEditor.style.backgroundColor = wc;
    }

    function rotatePreview(view, btn) {
        const scene = document.getElementById('preview3dScene');
        const rotations = {
            'default': 'translate(-50%, -50%) rotateX(-10deg) rotateY(-25deg)',
            'front':   'translate(-50%, -50%) rotateX(0deg) rotateY(0deg)',
            'back':    'translate(-50%, -50%) rotateX(0deg) rotateY(180deg)',
            'left':    'translate(-50%, -50%) rotateX(0deg) rotateY(90deg)',
            'right':   'translate(-50%, -50%) rotateX(0deg) rotateY(-90deg)',
            'top':     'translate(-50%, -50%) rotateX(90deg) rotateY(0deg)',
        };
        scene.style.transform = rotations[view] || rotations['default'];
        document.querySelectorAll('.preview-rot-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
    }

    async function deleteMediaItem(id, btnEl) {
        if (!confirm('Yakin hapus media ini?')) return;
        const url = window.v3dRoutes.deleteMedia.replace('__MEDIA_ID__', id);
        try {
            const response = await fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': window.v3dCsrf, 'Accept': 'application/json' } });
            const data = await response.json();
            if (data.success) {
                mediaItems = mediaItems.filter(m => m.id !== id);
                if (activeMediaId === id) deselectItem();
                renderWallItems();
                const listItem = btnEl.closest('.media-list-item');
                if (listItem) listItem.remove();
                showToast('Media berhasil dihapus.');
            }
        } catch (error) { console.error(error); alert('Gagal menghapus.'); }
    }

    function addMediaToList(media) {
        const noMsg = document.getElementById('noMediaMsg');
        if (noMsg) noMsg.remove();
        const list = document.getElementById('mediaList');
        const html = `
        <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg border border-gray-100 media-list-item" data-id="${media.id}">
            <div class="w-12 h-10 flex-shrink-0 rounded overflow-hidden bg-gray-200">
                ${media.type === 'image'
                    ? '<img src="/storage/' + media.file_path + '" class="w-full h-full object-cover">'
                    : '<div class="w-full h-full flex items-center justify-center text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>'}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-gray-800 truncate">${media.type.charAt(0).toUpperCase() + media.type.slice(1)} #${media.id}</p>
                <p class="text-xs text-gray-500">Dinding: ${media.wall.charAt(0).toUpperCase() + media.wall.slice(1)}</p>
            </div>
            <button type="button" onclick="deleteMediaItem(${media.id}, this)" class="p-1.5 text-red-500 hover:bg-red-50 rounded transition-colors" title="Hapus">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>`;
        list.insertAdjacentHTML('beforeend', html);
    }

    document.addEventListener('DOMContentLoaded', () => {
        updatePreviewColors();
    });
</script>
<script src="{{ asset('js/cms/virtual_3d_rooms.js') }}"></script>
<script>
    // Integration logic for edit page
    // Override uploadNewMedia to use custom upload fields from the left panel
    window.uploadNewMedia = async function() {
        const fileInput = document.getElementById('uploadFile');
        if (!fileInput || !fileInput.files.length) {
            alert('Pilih file untuk diunggah!');
            return;
        }

        const formData = new FormData();
        formData.append('file', fileInput.files[0]);
        formData.append('wall', document.getElementById('uploadWall').value);
        formData.append('type', document.getElementById('uploadType').value);
        formData.append('position_x', 50);
        formData.append('position_y', 50);
        formData.append('width', 30);
        formData.append('height', 40);

        try {
            const response = await fetch(window.v3dRoutes.upload, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': window.v3dCsrf },
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                mediaItems.push(data.media);
                renderWallItems();
                selectItem(data.media.id);
                fileInput.value = '';
                addMediaToList(data.media);
                showToast('Media berhasil diunggah!');
            } else {
                alert('Upload gagal: ' + (data.message || 'Error'));
            }
        } catch (error) {
            console.error(error);
            alert('Error uploading media.');
        }
    };
</script>
@endpush

