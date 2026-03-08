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

/* Door on back wall */
.room3d-door {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 80px;
    background: rgba(100, 116, 139, 0.5);
    border: 1px solid rgba(255,255,255,0.3);
    border-bottom: none;
    border-radius: 4px 4px 0 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
    color: rgba(255,255,255,0.7);
}

.room3d-door-knob {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    position: absolute;
    right: 6px;
    top: 50%;
}

/* Preview rotate buttons */
.preview-rot-btn {
    padding: 4px 10px;
    font-size: 11px;
    background: rgba(255,255,255,0.1);
    color: #e2e8f0;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.15s;
}
.preview-rot-btn:hover {
    background: rgba(255,255,255,0.2);
}
.preview-rot-btn.active {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
}
</style>
@endpush

@php
    $isEdit = false;
@endphp

@section('breadcrumb_parent', 'CMS / Ruangan Virtual 3D')
@section('breadcrumb_active', 'Tambah Ruangan')

@section('content')
<div class="mb-4">
    <a href="{{ route('cms.features.virtual_3d_rooms.index', $feature) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-white text-sm font-medium transition-colors shadow-sm" style="background-color: #818284;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Daftar Ruangan
    </a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Tambah Ruangan Virtual 3D</h1>
    <p class="text-sm text-gray-500 mt-1">Atur informasi ruangan, warna dinding/lantai/atap, dan hotspot navigasi</p>
</div>

<form action="{{ route('cms.features.virtual_3d_rooms.store', $feature) }}" method="POST" enctype="multipart/form-data" id="virtual3d-room-form">
    @csrf
    <input type="hidden" name="auto_thumbnail" id="autoThumbnailInput">

    <div class="flex gap-6 items-start" style="flex-wrap: nowrap;">

        <!-- Left Column: Form & Hotspots -->
        <div class="space-y-6" style="width: 38%; min-width: 350px; flex-shrink: 0;">

            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Informasi Ruangan</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ruangan <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Ruangan</label>
                        <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1.5">Gambar preview untuk daftar ruangan (JPG, PNG, WEBP)</p>
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
                            <input type="color" name="wall_color" id="wallColorInput" value="{{ old('wall_color', '#e5e7eb') }}" class="w-10 h-10 p-1 border border-gray-300 rounded-lg cursor-pointer" onchange="updatePreviewColors()">
                            <input type="text" id="wallColorText" value="{{ old('wall_color', '#e5e7eb') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna Lantai</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="floor_color" id="floorColorInput" value="{{ old('floor_color', '#8B7355') }}" class="w-10 h-10 p-1 border border-gray-300 rounded-lg cursor-pointer" onchange="updatePreviewColors()">
                            <input type="text" id="floorColorText" value="{{ old('floor_color', '#8B7355') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna Atap</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="ceiling_color" id="ceilingColorInput" value="{{ old('ceiling_color', '#f5f5f5') }}" class="w-10 h-10 p-1 border border-gray-300 rounded-lg cursor-pointer" onchange="updatePreviewColors()">
                            <input type="text" id="ceilingColorText" value="{{ old('ceiling_color', '#f5f5f5') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Door / Hotspot Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5" x-data="{ doorType: '{{ old('door_link_type', 'none') }}' }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-800">Pengaturan Pintu / Hotspot</h3>
                </div>
                <p class="text-xs text-gray-500 mb-4">Pintu berada di dinding belakang ruangan 3D dan bisa mengarahkan pengunjung ke halaman atau ruangan lain.</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Tautan Pintu</label>
                        <select name="door_link_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" x-model="doorType">
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
                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Ruangan tersedia: {{ $allRooms->count() }}</p>
                    </div>

                    <div x-show="doorType === 'url'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Target URL</label>
                        <input type="text" x-bind:name="doorType === 'url' ? 'door_target' : ''" value="{{ old('door_target') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="https://...">
                    </div>

                    <div x-show="doorType !== 'none'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Label Pintu (Opsional)</label>
                        <input type="text" name="door_label" value="{{ old('door_label') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="Contoh: KELUAR">
                    </div>
                </div>
            </div>

            <!-- Media Dinding (disabled on create – available after save) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 opacity-60">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-800">Media Dinding (Foto / Video)</h3>
                </div>
                <div class="text-center py-6 border-2 border-dashed border-gray-200 rounded-lg bg-gray-50">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <p class="text-sm font-medium text-gray-500">Simpan ruangan terlebih dahulu</p>
                    <p class="text-xs text-gray-400 mt-1">Setelah menyimpan, Anda akan diarahkan ke halaman edit untuk menambah foto/video ke dinding ruangan.</p>
                </div>
            </div>

        </div>

        <!-- Right Column: 3D Preview -->
        <div class="w-full" style="width: 62%;">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Preview Ruangan 3D</h3>
                <p class="text-xs text-gray-500 mb-4">Preview langsung ruangan 3D sesuai pengaturan warna Anda</p>

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

                    <!-- Rotation controls overlay -->
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
        </div>

    </div>

    <!-- Sticky Footer Actions -->
    <div class="mt-8 flex justify-end gap-3 pb-8">
        <a href="{{ route('cms.features.virtual_3d_rooms.index', $feature) }}" class="px-5 py-2.5 bg-gray-100 border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 active:bg-gray-300 transition-colors shadow-sm">
            Batal
        </a>
        <button type="submit" id="saveRoomBtn" class="px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm flex items-center gap-2" style="background-color:#1d4ed8;" onmouseover="this.style.backgroundColor='#1e40af'" onmouseout="this.style.backgroundColor='#1d4ed8'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
            Simpan Ruangan
        </button>
    </div>
</form>
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
                // Since this is create page, we just take current state
                html2canvas(previewContainer, {
                    backgroundColor: '#1e293b',
                    useCORS: true,
                    logging: false
                }).then(canvas => {
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
    }

    // Rotate preview
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

    // Initialize on load
    document.addEventListener('DOMContentLoaded', () => {
        updatePreviewColors();
    });
</script>
@endpush
