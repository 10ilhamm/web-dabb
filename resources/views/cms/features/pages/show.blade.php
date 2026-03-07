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
            <form action="{{ route('cms.features.pages.sections.store', [$feature, $page]) }}" method="POST" enctype="multipart/form-data" @submit="submitForm($event, 'add')" class="px-6 py-5 space-y-4">
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

                    <!-- Preview gambar -->
                    <div x-show="addSection.images.length > 0" class="space-y-4 mb-4">
                        <template x-for="img in addSection.images" :key="img.id">
                            <div class="relative" style="margin-top: 8px;"
                                x-data="imageItem(img, 'add')" x-init="initItem()">
                                <div class="relative overflow-hidden rounded-lg border border-gray-200 bg-gray-50 cursor-crosshair"
                                    style="height: 180px;"
                                    x-ref="container"
                                    @mousedown="onMouseDown($event)"
                                    @touchstart.passive="onTouchStart($event)">
                                    <img x-ref="imgEl" :src="img.preview"
                                        class="absolute inset-0 pointer-events-none select-none w-full h-full object-cover">
                                    <div x-ref="focalEl"
                                        class="absolute w-8 h-8 border-2 border-white rounded-full shadow-lg pointer-events-none flex items-center justify-center"
                                        style="background-color:rgba(59,130,246,0.4);transform:translate(-50%,-50%)">
                                        <div class="w-1 h-1 bg-white rounded-full"></div>
                                    </div>
                                </div>
                                <input type="hidden" name="image_positions[]" :value="img.x + '% ' + img.y + '%'">
                                <button type="button"
                                    @click.stop.prevent="$dispatch('remove-image', { id: img.id, mode: 'add' })"
                                    class="absolute bg-red-500 text-white rounded-full flex items-center justify-center shadow-md hover:bg-red-600 transition-colors cursor-pointer"
                                    style="width: 28px; height: 28px; top: -4px; right: -4px; z-index: 50; line-height: 1;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    <!-- Upload Button -->
                    <div class="relative">
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
            <form :action="`{{ route('cms.features.pages.show', [$feature, $page]) }}/sections/${editSection.id}`" method="POST" enctype="multipart/form-data" @submit="submitForm($event, 'edit')" class="px-6 py-5 space-y-4">
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
                <!-- Unified Image List -->
                <div x-show="editSection.images && editSection.images.length > 0" class="space-y-4 pb-2">
                    <label class="block text-sm font-medium text-gray-700">Gambar (Geser untuk menyesuaikan posisi)</label>
                    <template x-for="img in editSection.images" :key="img.id">
                        <div class="relative" style="margin-top: 8px;"
                            x-data="imageItem(img, 'edit')" x-init="initItem()">
                            <div class="relative overflow-hidden rounded-lg border border-gray-200 bg-gray-50 cursor-crosshair"
                                style="height: 180px;"
                                x-ref="container"
                                @mousedown="onMouseDown($event)"
                                @touchstart.passive="onTouchStart($event)">
                                <img x-ref="imgEl" :src="img.preview"
                                    class="absolute inset-0 pointer-events-none select-none w-full h-full object-cover">
                                <div x-ref="focalEl"
                                    class="absolute w-8 h-8 border-2 border-white rounded-full shadow-lg pointer-events-none flex items-center justify-center"
                                    style="background-color:rgba(59,130,246,0.4);transform:translate(-50%,-50%)">
                                    <div class="w-1 h-1 bg-white rounded-full"></div>
                                </div>
                            </div>

                            <template x-if="img.isExisting">
                                <input type="hidden" name="existing_images[]" :value="img.path">
                            </template>
                            <input type="hidden" name="image_positions[]" :value="img.x + '% ' + img.y + '%'">

                            <button type="button"
                                @click.stop.prevent="$dispatch('remove-image', { id: img.id, mode: 'edit' })"
                                class="absolute bg-red-500 text-white rounded-full flex items-center justify-center shadow-md hover:bg-red-600 transition-colors cursor-pointer"
                                style="width: 28px; height: 28px; top: -4px; right: -4px; z-index: 50; line-height: 1;">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>
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
/**
 * Sub-component: tiap gambar preview punya x-data sendiri
 * agar drag via x-ref tidak terganggu oleh Alpine x-for re-render.
 */
function imageItem(img, mode) {
    return {
        img: img,
        mode: mode,
        initItem() {
            this.applyPosition();
        },
        applyPosition() {
            const imgEl = this.$refs.imgEl;
            const focalEl = this.$refs.focalEl;
            if (imgEl) imgEl.style.objectPosition = this.img.x + '% ' + this.img.y + '%';
            if (focalEl) {
                focalEl.style.left = this.img.x + '%';
                focalEl.style.top = this.img.y + '%';
            }
        },
        calcPos(clientX, clientY) {
            const rect = this.$refs.container.getBoundingClientRect();
            return {
                x: parseFloat(Math.max(0, Math.min(100, ((clientX - rect.left) / rect.width) * 100)).toFixed(2)),
                y: parseFloat(Math.max(0, Math.min(100, ((clientY - rect.top) / rect.height) * 100)).toFixed(2))
            };
        },
        onMouseDown(e) {
            if (e.target.closest('button')) return;
            e.preventDefault();
            const update = (ev) => {
                const pos = this.calcPos(ev.clientX, ev.clientY);
                this.img.x = pos.x;
                this.img.y = pos.y;
                this.applyPosition();
            };
            const stop = () => {
                window.removeEventListener('mousemove', update);
                window.removeEventListener('mouseup', stop);
            };
            window.addEventListener('mousemove', update);
            window.addEventListener('mouseup', stop);
            update(e);
        },
        onTouchStart(e) {
            if (e.target.closest('button')) return;
            const touch = e.touches[0];
            const update = (ev) => {
                const t = ev.touches[0];
                const pos = this.calcPos(t.clientX, t.clientY);
                this.img.x = pos.x;
                this.img.y = pos.y;
                this.applyPosition();
            };
            const stop = () => {
                window.removeEventListener('touchmove', update);
                window.removeEventListener('touchend', stop);
            };
            window.addEventListener('touchmove', update, { passive: true });
            window.addEventListener('touchend', stop);
            update(e);
        }
    };
}

function sectionManager() {
    let _idCounter = 1;

    return {
        addSection: { open: false, images: [] },
        editSection: { open: false, id: null, title: '', description: '', order: 0, images: [] },
        deleteSection: { open: false, id: null, name: '' },
        imageModal: { open: false, src: '' },
        _files: {},  // map id -> File object, terpisah dari Alpine state

        init() {
            // Listen event remove-image dari child component
            this.$el.addEventListener('remove-image', (e) => {
                this.removeImage(e.detail.id, e.detail.mode);
            });
        },

        getNextId(prefix) {
            return prefix + '-' + Date.now() + '-' + (_idCounter++);
        },

        parsePos(pos) {
            if (!pos || pos === 'center') return { x: 50, y: 50 };
            const parts = pos.split(' ');
            if (parts.length < 2) return { x: 50, y: 50 };
            return {
                x: parseFloat(parts[0]) || 50,
                y: parseFloat(parts[1]) || 50
            };
        },

        openAddSection() {
            this.addSection.images = [];
            this._files = {};
            this.addSection.open = true;
        },

        openEditSection(id, title, description, order, images, positions) {
            this.editSection.id = id;
            this.editSection.title = title;
            this.editSection.description = description;
            this.editSection.order = order;
            this._files = {};

            const existingImages = [];
            if (images && images.length) {
                images.forEach((path, i) => {
                    const pos = this.parsePos(positions ? positions[i] : null);
                    existingImages.push({
                        id: this.getNextId('ext'),
                        path: path,
                        preview: '{{ asset("storage") }}/' + path,
                        x: pos.x,
                        y: pos.y,
                        isExisting: true
                    });
                });
            }
            this.editSection.images = existingImages;
            this.editSection.open = true;
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

        handleFileChange(event, mode) {
            const files = Array.from(event.target.files);
            const target = mode === 'add' ? this.addSection : this.editSection;

            files.forEach(file => {
                if (target.images.length >= 8) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    if (target.images.length >= 8) return;

                    const imgId = this.getNextId('new');
                    // Simpan File object di map terpisah, bukan di Alpine reactive state
                    this._files[imgId] = file;

                    target.images = [...target.images, {
                        id: imgId,
                        preview: e.target.result,
                        x: 50,
                        y: 50,
                        isExisting: false
                    }];
                };
                reader.readAsDataURL(file);
            });
            // Reset native input
            event.target.value = '';
        },

        removeImage(id, mode) {
            const target = mode === 'add' ? this.addSection : this.editSection;
            // Hapus file reference
            delete this._files[id];
            // Hapus dari array — bikin array baru supaya Alpine detect perubahan
            target.images = target.images.filter(img => img.id !== id);
        },

        submitForm(event, mode) {
            const target = mode === 'add' ? this.addSection : this.editSection;
            const form = event.target;
            const fileInput = form.querySelector('input[type="file"]');

            // Rebuild file input hanya dari gambar baru yang masih ada
            const dt = new DataTransfer();
            target.images.forEach(img => {
                if (!img.isExisting && this._files[img.id]) {
                    dt.items.add(this._files[img.id]);
                }
            });
            fileInput.files = dt.files;
        }
    };
}
</script>
@endpush
@endsection
