@extends('layouts.guest')

@section('title', $feature->name . ' — ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
<link rel="stylesheet" href="{{ asset('css/feature-page.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
<style>
/* ── Virtual Tour Page ─────────────────────────────── */
.vt-hero {
    background: linear-gradient(135deg, #0f2a5c 0%, #174E93 60%, #1a6bbf 100%);
    padding: 4rem 0 3rem;
    color: white;
    position: relative;
    overflow: hidden;
}
.vt-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.vt-hero .container { position: relative; max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
.vt-hero h1 { font-size: 2.25rem; font-weight: 800; letter-spacing: -0.02em; margin: 0 0 0.5rem; }
.vt-hero p { font-size: 1rem; opacity: 0.8; margin: 0; }

.vt-rooms-section { background: #f8f9fb; padding: 4rem 0; }
.vt-rooms-section .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
.vt-section-title { font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem; }
.vt-section-sub   { font-size: 0.95rem; color: #6b7280; margin-bottom: 2rem; }

.vt-rooms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

/* ── Room Card ─── */
.vt-room-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid #e5e7eb;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
}
.vt-room-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
}
.vt-room-thumb {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #0f2a5c;
}
.vt-room-thumb img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.4s;
}
.vt-room-card:hover .vt-room-thumb img { transform: scale(1.05); }
.vt-room-thumb-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.3); font-size: 4rem;
}
.vt-room-badge {
    position: absolute; bottom: 0.75rem; right: 0.75rem;
    background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
    color: white; font-size: 0.75rem; font-weight: 600;
    padding: 0.3rem 0.7rem; border-radius: 999px;
    display: flex; align-items: center; gap: 0.4rem;
}
.vt-enter-btn {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    background: rgba(23,78,147,0.0);
    transition: background 0.25s;
}
.vt-room-card:hover .vt-enter-btn { background: rgba(23,78,147,0.65); }
.vt-enter-btn span {
    color: white; font-size: 0.9rem; font-weight: 700; letter-spacing: 0.05em;
    padding: 0.6rem 1.4rem; border: 2px solid white; border-radius: 999px;
    opacity: 0; transform: scale(0.9);
    transition: opacity 0.2s, transform 0.2s;
}
.vt-room-card:hover .vt-enter-btn span { opacity: 1; transform: scale(1); }

.vt-room-info { padding: 1.25rem; }
.vt-room-name { font-size: 1.05rem; font-weight: 700; color: #111827; margin: 0 0 0.35rem; }
.vt-room-desc { font-size: 0.85rem; color: #6b7280; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

/* ── Pannellum Modal ─── */
.vt-modal-overlay {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,0.92);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none; transition: opacity 0.25s;
}
.vt-modal-overlay.active { opacity: 1; pointer-events: all; }
.vt-modal-inner {
    position: relative; width: 95vw; height: 90vh;
    border-radius: 1rem; overflow: hidden;
    box-shadow: 0 32px 64px rgba(0,0,0,0.5);
    display: flex; flex-direction: column;
}
.vt-modal-header {
    position: absolute; top: 0; left: 0; right: 0;
    display: flex; align-items: center; justify-between: center;
    gap: 1rem; padding: 1rem 1.25rem;
    background: linear-gradient(to bottom, rgba(0,0,0,0.6) 0%, transparent 100%);
    z-index: 10;
    justify-content: space-between;
}
.vt-modal-title { color: white; font-size: 1.1rem; font-weight: 700; text-shadow: 0 1px 4px rgba(0,0,0,0.5); }
.vt-modal-close {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,0.2); backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,0.3);
    color: white; font-size: 1.2rem; line-height: 1;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.2s;
}
.vt-modal-close:hover { background: rgba(255,255,255,0.35); }
#vt-panorama { width: 100%; flex: 1; }
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="vt-hero">
    <div class="container">
        @if($feature->parent)
            <p style="font-size:0.8rem;opacity:0.6;margin-bottom:0.5rem;text-transform:uppercase;letter-spacing:0.08em;">
                {{ $feature->parent->name }}
            </p>
        @endif
        <h1>{{ $feature->name }}</h1>
        <p>Jelajahi pameran arsip 360° secara virtual</p>
    </div>
</div>

{{-- Room Grid --}}
<section class="vt-rooms-section">
    <div class="container">
        <h2 class="vt-section-title">Pilih Ruangan</h2>
        <p class="vt-section-sub">Klik salah satu ruangan di bawah untuk memulai tur virtual 360°</p>

        @if($virtualRooms->isEmpty())
            <div style="text-align:center;padding:4rem;color:#9ca3af;">
                <svg style="width:64px;height:64px;margin:0 auto 1rem;display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                <p>Belum ada ruangan yang tersedia.</p>
            </div>
        @else
            <div class="vt-rooms-grid">
                @foreach($virtualRooms as $room)
                <div class="vt-room-card"
                     onclick="openTour('{{ $room->id }}', '{{ addslashes($room->name) }}', '{{ $room->image_360_path ? asset('storage/'.$room->image_360_path) : '' }}')">
                    <div class="vt-room-thumb">
                        @if($room->thumbnail_path)
                            <img src="{{ asset('storage/'.$room->thumbnail_path) }}" alt="{{ $room->name }}" loading="lazy">
                        @else
                            <div class="vt-room-thumb-placeholder">🏛️</div>
                        @endif
                        <div class="vt-enter-btn"><span>MASUK RUANGAN</span></div>
                        <div class="vt-room-badge">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $room->hotspots_count }} hotspot
                        </div>
                    </div>
                    <div class="vt-room-info">
                        <h3 class="vt-room-name">{{ $room->name }}</h3>
                        @if($room->description)
                            <p class="vt-room-desc">{{ $room->description }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- Pannellum Fullscreen Modal --}}
<div class="vt-modal-overlay" id="vtModal">
    <div class="vt-modal-inner">
        <div class="vt-modal-header">
            <span class="vt-modal-title" id="vtModalTitle">Ruangan</span>
            <button class="vt-modal-close" onclick="closeTour()">&#x2715;</button>
        </div>
        <div id="vt-panorama"></div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<script>
let vtViewer = null;

// Pass hotspot data from server
const roomHotspots = @json(
    $virtualRooms->keyBy('id')->map(fn($r) => $r->hotspots ?? [])
);

function openTour(roomId, roomName, imageUrl) {
    if (!imageUrl) {
        alert('Panorama untuk ruangan ini belum tersedia.');
        return;
    }

    document.getElementById('vtModalTitle').textContent = roomName;
    document.getElementById('vtModal').classList.add('active');
    document.body.style.overflow = 'hidden';

    if (vtViewer) { vtViewer.destroy(); vtViewer = null; }

    const hotspots = (roomHotspots[roomId] || []).map(hs => ({
        pitch: parseFloat(hs.pitch),
        yaw:   parseFloat(hs.yaw),
        type:  'info',
        text:  hs.text_tooltip,
        cssClass: 'pnlm-hotspot-base pnlm-info',
    }));

    vtViewer = pannellum.viewer('vt-panorama', {
        type: 'equirectangular',
        panorama: imageUrl,
        autoLoad: true,
        autoRotate: -2,
        showZoomCtrl: true,
        mouseZoom: true,
        compass: false,
        hotSpots: hotspots,
    });
}

function closeTour() {
    document.getElementById('vtModal').classList.remove('active');
    document.body.style.overflow = '';
    if (vtViewer) { vtViewer.destroy(); vtViewer = null; }
}

// Close on backdrop click
document.getElementById('vtModal').addEventListener('click', function(e) {
    if (e.target === this) closeTour();
});

// Close on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeTour();
});
</script>
@endpush
