@extends('layouts.app')

@section('breadcrumb_parent', 'CMS / ' . __('cms.features.title') . ' / ' . $feature->name)
@section('breadcrumb_active', $page->title)

@section('content')
<div class="space-y-6" x-data="sectionManager()">

    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('cms.features.pages.index', $feature) }}"
            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ __('cms.feature_pages.sections_title', ['name' => $page->title]) }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ __('cms.feature_pages.sections_desc', ['name' => $page->title]) }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Sections List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-800">{{ __('cms.feature_pages.sections_title', ['name' => $page->title]) }}</h2>
            </div>
            <button @click="openAddSection()"
                class="flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('cms.feature_pages.add_section') }}
            </button>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($page->sections as $index => $section)
            <div class="p-6 hover:bg-gray-50/50 transition-colors">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ $index + 1 }}</span>
                            <h3 class="text-base font-semibold text-gray-800">{{ $section->title }}</h3>
                            <span class="text-xs text-gray-400">Urutan: {{ $section->order }}</span>
                        </div>
                        @if($section->description)
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit($section->description, 150) }}</p>
                        @endif
                        @if($section->images && count($section->images))
                            <div class="flex flex-wrap gap-2 mt-3">
                                @foreach($section->images as $imgIndex => $img)
                                <div class="relative group/image">
                                    <img src="{{ asset('storage/' . $img) }}" alt=""
                                        class="w-16 h-16 object-cover rounded-lg border border-gray-200 cursor-pointer"
                                        style="object-position: {{ $section->image_positions[$imgIndex] ?? 'center' }}"
                                        @click="openImageModal('{{ asset('storage/' . $img) }}')">
                                    <div class="absolute inset-0 bg-black/50 rounded-lg opacity-0 group-hover/image:opacity-100 transition-opacity flex items-center justify-center gap-1">
                                        <a href="{{ asset('storage/' . $img) }}" download
                                            class="p-1.5 bg-white/20 hover:bg-white/30 rounded-md text-white" title="Unduh">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                        </a>
                                        <button @click="openImageModal('{{ asset('storage/' . $img) }}')"
                                            class="p-1.5 bg-white/20 hover:bg-white/30 rounded-md text-white" title="Perbesar">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="#" @click.prevent="openEditSection({{ $section->id }}, '{{ addslashes($section->title) }}', `{{ addslashes($section->description ?? '') }}`, {{ $section->order }}, {{ json_encode($section->images ?? []) }}, {{ json_encode($section->image_positions ?? []) }})"
                            class="inline-flex items-center justify-center w-8 h-8 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <button @click="openDeleteSection({{ $section->id }}, '{{ addslashes($section->title) }}')"
                            class="inline-flex items-center justify-center w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-md transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-6 py-16 text-center">
                <div class="flex flex-col items-center gap-3">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-400 text-sm">Belum ada seksi. Klik "+ Tambah Seksi" untuk menambahkan.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ===== ADD SECTION MODAL ===== --}}
    <div x-show="addSection.open" x-cloak
        class="fixed inset-0 flex items-center justify-center p-4"
        style="z-index: 9999;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/60" @click="addSection.open = false" style="position: fixed; top: 0; right: 0; bottom: 0; left: 0;"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md z-[9999] max-h-[90vh] overflow-y-auto"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
                <h3 class="text-base font-semibold text-gray-800">{{ __('cms.feature_pages.add_section_title') }}</h3>
                <button @click="addSection.open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('cms.features.pages.sections.store', [$feature, $page]) }}" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm($event, 'add')" class="px-6 py-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('cms.feature_pages.section_form.title') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="{{ __('cms.feature_pages.section_form.title_placeholder') }}"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('cms.feature_pages.section_form.description') }}</label>
                    <textarea name="description" rows="4" placeholder="{{ __('cms.feature_pages.section_form.description_placeholder') }}"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-y"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('cms.feature_pages.section_form.images') }}</label>

                    <!-- Preview gambar: render via JS ke container ini -->
                    <div id="add-image-previews"></div>

                    <!-- Upload Button -->
                    <div class="relative mt-2">
                        <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                            @change="handleFileChange($event, 'add')"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full px-3.5 py-4 border-2 border-dashed border-gray-200 rounded-lg text-center bg-gray-50 hover:bg-gray-100 hover:border-blue-400 transition-all group">
                            <div class="flex flex-col items-center gap-1">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-600">{{ __('cms.feature_pages.add_section') }} Gambar</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">{{ __('cms.feature_pages.section_form.images_help') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('cms.feature_pages.section_form.order') }} <span class="text-red-500">*</span></label>
                    <input type="number" name="order" min="0" value="{{ $page->sections->count() + 1 }}" required
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" @click="addSection.open = false"
                        class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">{{ __('cms.common.cancel') }}</button>
                    <button type="submit"
                        class="px-4 py-2.5 text-sm font-semibold text-white bg-[#174E93] hover:bg-blue-800 rounded-lg transition-colors">{{ __('cms.feature_pages.add_section') }}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== EDIT SECTION MODAL ===== --}}
    <div x-show="editSection.open" x-cloak
        class="fixed inset-0 flex items-center justify-center p-4"
        style="z-index: 9999;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/60" @click="editSection.open = false" style="position: fixed; top: 0; right: 0; bottom: 0; left: 0;"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md z-[9999] max-h-[90vh] overflow-y-auto"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
                <h3 class="text-base font-semibold text-gray-800">{{ __('cms.feature_pages.edit_section_title') }}</h3>
                <button @click="editSection.open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form :action="`{{ route('cms.features.pages.show', [$feature, $page]) }}/sections/${editSection.id}`" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm($event, 'edit')" class="px-6 py-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('cms.feature_pages.section_form.title') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="title" x-model="editSection.title" required
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('cms.feature_pages.section_form.description') }}</label>
                    <textarea name="description" rows="4" x-model="editSection.description"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-y"></textarea>
                </div>

                <!-- Preview gambar edit: render via JS ke container ini -->
                <div id="edit-image-previews"></div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('cms.feature_pages.section_form.images') }}</label>
                    <div class="relative">
                        <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                            @change="handleFileChange($event, 'edit')"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full px-3.5 py-4 border-2 border-dashed border-gray-200 rounded-lg text-center bg-gray-50 hover:bg-gray-100 hover:border-blue-400 transition-all group">
                            <div class="flex flex-col items-center gap-1">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-600">Tambah Gambar Baru</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('cms.feature_pages.section_form.order') }} <span class="text-red-500">*</span></label>
                    <input type="number" name="order" x-model="editSection.order" min="0" required
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" @click="editSection.open = false"
                        class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">{{ __('cms.common.cancel') }}</button>
                    <button type="submit"
                        class="px-4 py-2.5 text-sm font-semibold text-white bg-[#174E93] hover:bg-blue-800 rounded-lg transition-colors">{{ __('cms.common.save_changes') }}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== DELETE SECTION MODAL ===== --}}
    <div x-show="deleteSection.open" x-cloak
        class="fixed inset-0 flex items-center justify-center p-4"
        style="z-index: 9999;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/60" @click="deleteSection.open = false" style="position: fixed; top: 0; right: 0; bottom: 0; left: 0;"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-sm z-[9999] p-6"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="flex flex-col items-center text-center gap-4">
                <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">{{ __('cms.feature_pages.delete_section.title') }}</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ __('cms.feature_pages.delete_section.confirm', ['name' => '']) }}
                        <strong x-text="deleteSection.name" class="text-gray-700"></strong>
                    </p>
                </div>
                <div class="flex items-center gap-3 w-full">
                    <button @click="deleteSection.open = false"
                        class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">{{ __('cms.common.cancel') }}</button>
                    <form :action="`{{ route('cms.features.pages.show', [$feature, $page]) }}/sections/${deleteSection.id}`" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2.5 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors">{{ __('cms.feature_pages.delete_section.yes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== IMAGE MODAL ===== --}}
    <div x-show="imageModal.open" x-cloak
        class="fixed inset-0 flex items-center justify-center p-4"
        style="z-index: 9999;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/80" @click="imageModal.open = false" style="position: fixed; top: 0; right: 0; bottom: 0; left: 0;"></div>
        <div class="relative z-[9999] max-w-3xl w-full"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            <button @click="imageModal.open = false"
                class="absolute -top-10 right-0 text-white hover:text-gray-300 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img :src="imageModal.src" class="w-full h-auto rounded-lg shadow-2xl">
            <div class="mt-4 flex justify-center gap-4">
                <a :href="imageModal.src" download
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Unduh
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function sectionManager() {
    let _idCounter = 1;
    let _isGlobalSubmitting = false;

    // Data gambar disimpan di plain object, BUKAN di Alpine reactive state
    // Format: { id, preview, x, y, isExisting, path?, file? }
    const _imageStore = { add: [], edit: [] };
    const _files = {};

    function getNextId(prefix) {
        return prefix + '-' + Date.now() + '-' + (_idCounter++);
    }

    function parsePos(pos) {
        if (!pos || pos === 'center') return { x: 50, y: 50 };
        const parts = pos.split(' ');
        if (parts.length < 2) return { x: 50, y: 50 };
        return { x: parseFloat(parts[0]) || 50, y: parseFloat(parts[1]) || 50 };
    }

    // ===== DOM RENDERING =====
    // Render semua gambar preview ke container via vanilla DOM
    // Ini sepenuhnya di luar Alpine — tidak ada x-for, tidak ada x-data nested
    function renderPreviews(mode) {
        const containerId = mode === 'add' ? 'add-image-previews' : 'edit-image-previews';
        const container = document.getElementById(containerId);
        if (!container) return;

        // Kosongkan container
        container.innerHTML = '';

        const images = _imageStore[mode];
        if (!images.length) return;

        // Label
        if (mode === 'edit') {
            const label = document.createElement('label');
            label.className = 'block text-sm font-medium text-gray-700 mb-2';
            label.textContent = 'Gambar (Geser untuk menyesuaikan posisi)';
            container.appendChild(label);
        }

        const cols = Math.min(Math.max(images.length, 1), 4);
        // Guest container in desktop is ~1140px. 
        // With a 10px gap, the guest item width is approximately:
        const guestItemWidth = (1140 - ((cols - 1) * 10)) / cols;
        const guestItemHeight = 180;
        const guestAspectRatio = guestItemWidth / guestItemHeight;

        images.forEach((img) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative group mb-4 w-full';
            wrapper.dataset.imgId = img.id;

            // Drag container
            const dragBox = document.createElement('div');
            dragBox.className = 'relative overflow-hidden rounded-lg bg-gray-900 cursor-crosshair w-full flex items-center justify-center';
            // Match the precise aspect ratio computed for guest view on desktop
            dragBox.style.width = '100%';
            dragBox.style.aspectRatio = guestAspectRatio.toString();

            // Image
            const imgEl = document.createElement('img');
            imgEl.src = img.preview;
            imgEl.className = 'absolute pointer-events-none select-none w-full h-full object-cover transition-transform duration-300';
            imgEl.style.objectPosition = img.x + '% ' + img.y + '%';
            dragBox.appendChild(imgEl);

            // Focal point
            const focal = document.createElement('div');
            focal.className = 'absolute w-6 h-6 border-2 border-white rounded-full shadow-lg pointer-events-none flex items-center justify-center';
            focal.style.cssText = 'background-color:rgba(59,130,246,0.6);transform:translate(-50%,-50%); transition: opacity 0.2s;';
            focal.style.left = img.x + '%';
            focal.style.top = img.y + '%';
            const dot = document.createElement('div');
            dot.className = 'w-1.5 h-1.5 bg-white rounded-full';
            focal.appendChild(dot);
            dragBox.appendChild(focal);

            // Drag handler
            dragBox.addEventListener('mousedown', function(e) {
                if (e.target.closest('button')) return;
                e.preventDefault();
                const updatePos = (ev) => {
                    const rect = dragBox.getBoundingClientRect();
                    if (rect.width === 0) return;
                    const px = parseFloat(Math.max(0, Math.min(100, ((ev.clientX - rect.left) / rect.width) * 100)).toFixed(2));
                    const py = parseFloat(Math.max(0, Math.min(100, ((ev.clientY - rect.top) / rect.height) * 100)).toFixed(2));
                    imgEl.style.objectPosition = px + '% ' + py + '%';
                    focal.style.left = px + '%';
                    focal.style.top = py + '%';
                    img.x = px;
                    img.y = py;
                };
                const stop = () => {
                    window.removeEventListener('mousemove', updatePos);
                    window.removeEventListener('mouseup', stop);
                };
                window.addEventListener('mousemove', updatePos);
                window.addEventListener('mouseup', stop);
                updatePos(e);
            });

            wrapper.appendChild(dragBox);

            // Delete button
            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.className = 'absolute bg-red-500 text-white rounded-full flex items-center justify-center shadow-md hover:bg-red-600 transition-colors cursor-pointer z-50';
            delBtn.style.cssText = 'width:24px;height:24px;top:-8px;right:-8px;line-height:1';
            delBtn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
            delBtn.addEventListener('mousedown', (e) => e.stopPropagation());
            delBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();
                // Hapus dari store
                const idx = _imageStore[mode].findIndex(i => i.id === img.id);
                if (idx !== -1) _imageStore[mode].splice(idx, 1);
                delete _files[img.id];
                
                // Re-render semua untuk menghitung ulang grid cols
                renderPreviews(mode);
            });
            wrapper.appendChild(delBtn);

            container.appendChild(wrapper);
        });
    }

    return {
        addSection: { open: false },
        editSection: { open: false, id: null, title: '', description: '', order: 0 },
        deleteSection: { open: false, id: null, name: '' },
        imageModal: { open: false, src: '' },
        isSubmitting: false,

        openAddSection() {
            _imageStore.add = [];
            Object.keys(_files).forEach(k => delete _files[k]);
            this.addSection.open = true;
            this.$nextTick(() => renderPreviews('add'));
        },

        openEditSection(id, title, description, order, images, positions) {
            this.editSection.id = id;
            this.editSection.title = title;
            this.editSection.description = description;
            this.editSection.order = order;

            _imageStore.edit = [];
            Object.keys(_files).forEach(k => delete _files[k]);

            if (images && images.length) {
                images.forEach((path, i) => {
                    const pos = parsePos(positions ? positions[i] : null);
                    _imageStore.edit.push({
                        id: getNextId('ext'),
                        path: path,
                        preview: '{{ asset("storage") }}/' + path,
                        x: pos.x,
                        y: pos.y,
                        isExisting: true
                    });
                });
            }

            this.editSection.open = true;
            this.$nextTick(() => renderPreviews('edit'));
        },

        openDeleteSection(id, name) {
            this.deleteSection.id = id;
            this.deleteSection.name = name;
            this.deleteSection.open = true;
        },

        openImageModal(src) {
            this.imageModal.src = src;
            this.imageModal.open = true;
        },

        async handleFileChange(event, mode) {
            const files = Array.from(event.target.files);

            const compressImage = (file) => {
                return new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = new Image();
                        img.onload = () => {
                            const canvas = document.createElement('canvas');
                            let width = img.width;
                            let height = img.height;
                            const MAX_SIZE = 1280;

                            if (width > height && width > MAX_SIZE) {
                                height *= MAX_SIZE / width;
                                width = MAX_SIZE;
                            } else if (height > MAX_SIZE) {
                                width *= MAX_SIZE / height;
                                height = MAX_SIZE;
                            }

                            canvas.width = width;
                            canvas.height = height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, width, height);

                            canvas.toBlob((blob) => {
                                const originalName = file.name.replace(/\.[^/.]+$/, "");
                                const newFile = new File([blob], originalName + ".webp", {
                                    type: 'image/webp',
                                    lastModified: Date.now()
                                });
                                resolve({ file: newFile, preview: e.target.result });
                            }, 'image/webp', 0.65);
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            };

            for (const file of files) {
                const compressed = await compressImage(file);
                const imgId = getNextId('new');
                _files[imgId] = compressed.file;
                
                _imageStore[mode].push({
                    id: imgId,
                    preview: compressed.preview,
                    x: 50,
                    y: 50,
                    isExisting: false
                });
            }
            
            renderPreviews(mode);
            event.target.value = '';
        },

        submitForm(event, mode) {
            event.preventDefault();
            if (_isGlobalSubmitting) return;
            _isGlobalSubmitting = true;

            const form = event.target;
            const images = _imageStore[mode];

            // Bangun FormData dari field form yang sudah ada (title, description, order, _token, _method)
            const formData = new FormData(form);

            // Hapus field images[] & image_positions[] & existing_images[] bawaan form
            formData.delete('images[]');
            formData.delete('image_positions[]');
            formData.delete('existing_images[]');

            // Tambahkan data gambar dari _imageStore
            images.forEach(img => {
                formData.append('image_positions[]', img.x + '% ' + img.y + '%');

                if (img.isExisting) {
                    formData.append('existing_images[]', img.path);
                }
            });

            // Tambahkan file baru
            images.forEach(img => {
                if (!img.isExisting && _files[img.id]) {
                    formData.append('images[]', _files[img.id]);
                }
            });

            // Kirim via fetch
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Menyimpan...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            }).then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else if (response.ok) {
                    window.location.reload();
                } else {
                    window.location.reload();
                }
            }).catch(() => {
                window.location.reload(); // Mengabaikan pesan error jaringan dan merefresh halaman (karena konten seringkali sudah terkirim)
            });
        }
    };
}
</script>
@endpush
@endsection
