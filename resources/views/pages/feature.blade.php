@extends('layouts.guest')

@section('title', $feature->name . ' — ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
<link rel="stylesheet" href="{{ asset('css/feature-page.css') }}">
@endpush

@section('content')
    <!-- Breadcrumb Bar -->
    <div class="feature-breadcrumb">
        <div class="container">
            @if($feature->parent)
                <a href="#">{{ app()->getLocale() === 'en' && $feature->parent->name_en ? $feature->parent->name_en : $feature->parent->name }}</a>
                <span>/</span>
            @endif
            <span class="current">{{ app()->getLocale() === 'en' && $feature->name_en ? $feature->name_en : $feature->name }}</span>
        </div>
    </div>

    <!-- Hero Banner -->
    <div class="feature-hero">
        <div class="container">
            <h1>{{ mb_strtoupper(app()->getLocale() === 'en' && $feature->name_en ? $feature->name_en : $feature->name) }}</h1>
        </div>
    </div>

    <!-- Content Area -->
    <div class="feature-content">
        <div class="container">

            @if(isset($pages) && $pages->count() > 0)
            {{-- Multi-page content --}}
            @if($currentPage->description)
            <div class="feature-welcome-box">
                <h3>{{ __('cms.feature_pages.welcome', ['name' => (app()->getLocale() === 'en' && $feature->name_en ? $feature->name_en : $feature->name)]) }}</h3>
                <p>{{ app()->getLocale() === 'en' && $currentPage->description_en ? $currentPage->description_en : $currentPage->description }}</p>
            </div>
            @endif

            <!-- List Title & Search -->
            <div class="feature-list-header">
                <h2 class="feature-list-title">{{ __('cms.feature_pages.list_title', ['name' => (app()->getLocale() === 'en' && $feature->name_en ? $feature->name_en : $feature->name)]) }}</h2>
                <div class="feature-search">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="{{ __('cms.feature_pages.search_placeholder') }}" id="sectionSearch" onkeyup="filterSections()">
                    <button type="button" class="search-btn" onclick="filterSections()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Sections -->
            <div class="feature-sections" id="featureSections">
                @foreach($currentPage->sections as $section)
                <div class="feature-section" data-title="{{ mb_strtolower($section->title) }}">
                    <div class="section-title-box">
                        <h3>{{ app()->getLocale() === 'en' && $section->title_en ? $section->title_en : $section->title }}</h3>
                    </div>

                    @if($section->images && count($section->images))
                    <div class="section-images section-images-{{ min(count($section->images), 4) }}cols">
                        @foreach($section->images as $imgIndex => $img)
                        <div class="section-img-wrap">
                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $section->title }}" loading="lazy"
                                style="object-position: {{ $section->image_positions[$imgIndex] ?? 'center' }}">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($section->description)
                    <div class="section-description">
                        <p>{{ app()->getLocale() === 'en' && $section->description_en ? $section->description_en : $section->description }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($totalPages > 1)
            <div class="feature-pagination">
                @if($currentPageNum > 1)
                    <a href="{{ route('feature.page', [$feature, $currentPageNum - 1]) }}" class="page-btn page-prev">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                @endif

                @for($i = 1; $i <= $totalPages; $i++)
                    <a href="{{ route('feature.page', [$feature, $i]) }}"
                       class="page-num {{ $i === $currentPageNum ? 'active' : '' }}">{{ $i }}</a>
                @endfor

                @if($currentPageNum < $totalPages)
                    <a href="{{ route('feature.page', [$feature, $currentPageNum + 1]) }}" class="page-btn page-next">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @endif
            </div>
            @endif

            @else
            {{-- Simple content from CMS --}}
            @if($feature->content)
            <div class="feature-simple-content">
                <div class="prose max-w-none">
                    {!! app()->getLocale() === 'en' && $feature->content_en ? $feature->content_en : $feature->content !!}
                </div>
            </div>
            @endif
            @endif

        </div>
    </div>
@endsection

@push('scripts')
<script>
function filterSections() {
    const query = document.getElementById('sectionSearch').value.toLowerCase();
    const sections = document.querySelectorAll('.feature-section');
    sections.forEach(function(section) {
        const title = section.getAttribute('data-title');
        section.style.display = title.includes(query) ? '' : 'none';
    });
}
</script>
@endpush
