<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\FeaturePage;
use App\Models\FeaturePageSection;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeaturePageController extends Controller
{
    /**
     * List pages for a feature (CMS).
     */
    public function index(Feature $feature)
    {
        $feature->load(['pages' => function ($q) {
            $q->withCount('sections');
        }, 'parent']);

        return view('cms.features.pages.index', compact('feature'));
    }

    /**
     * Store a new page for a feature.
     */
    public function store(Request $request, Feature $feature, TranslationService $translationService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ]);

        $validated['feature_id'] = $feature->id;
        $validated['title_en'] = $translationService->translate($validated['title']);
        if (! empty($validated['description'])) {
            $validated['description_en'] = $translationService->translate($validated['description']);
        }

        FeaturePage::create($validated);

        return redirect()->route('cms.features.pages.index', $feature)
            ->with('success', __('cms.feature_pages.flash.page_added'));
    }

    /**
     * Show page detail - manage sections (CMS).
     */
    public function show(Feature $feature, FeaturePage $page)
    {
        $page->load('sections');
        $feature->load('parent');

        return view('cms.features.pages.show', compact('feature', 'page'));
    }

    /**
     * Update a page.
     */
    public function update(Request $request, Feature $feature, FeaturePage $page, TranslationService $translationService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ]);

        $validated['title_en'] = $translationService->translate($validated['title']);
        $validated['description_en'] = ! empty($validated['description'])
            ? $translationService->translate($validated['description'])
            : null;

        $page->update($validated);

        return redirect()->route('cms.features.pages.index', $feature)
            ->with('success', __('cms.feature_pages.flash.page_updated'));
    }

    /**
     * Delete a page.
     */
    public function destroy(Feature $feature, FeaturePage $page)
    {
        // Delete section images
        foreach ($page->sections as $section) {
            $this->deleteSectionImages($section);
        }

        $page->delete();

        return redirect()->route('cms.features.pages.index', $feature)
            ->with('success', __('cms.feature_pages.flash.page_deleted'));
    }

    /**
     * Store a new section for a page.
     */
    public function storeSection(Request $request, Feature $feature, FeaturePage $page, TranslationService $translationService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'images' => 'nullable|array', // unlimited
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_positions' => 'nullable|array',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('features/sections', 'public');
            }
        }

        FeaturePageSection::create([
            'feature_page_id' => $page->id,
            'title' => $validated['title'],
            'title_en' => $translationService->translate($validated['title']),
            'description' => $validated['description'] ?? null,
            'description_en' => ! empty($validated['description'])
                ? $translationService->translate($validated['description'])
                : null,
            'images' => $imagePaths ?: null,
            'image_positions' => $validated['image_positions'] ?? null,
            'order' => $validated['order'],
        ]);

        return redirect()->route('cms.features.pages.show', [$feature, $page])
            ->with('success', __('cms.feature_pages.flash.section_added'));
    }

    /**
     * Update a section.
     */
    public function updateSection(Request $request, Feature $feature, FeaturePage $page, FeaturePageSection $section, TranslationService $translationService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'images' => 'nullable|array', // unlimited
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'string',
            'image_positions' => 'nullable|array',
        ]);

        // Keep existing images that weren't removed
        $existingImages = $validated['existing_images'] ?? [];

        // Delete removed images from storage
        $oldImages = $section->images ?? [];
        foreach ($oldImages as $oldImage) {
            if (! in_array($oldImage, $existingImages)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        // Add new uploaded images
        $imagePaths = $existingImages;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('features/sections', 'public');
            }
        }

        $section->update([
            'title' => $validated['title'],
            'title_en' => $translationService->translate($validated['title']),
            'description' => $validated['description'] ?? null,
            'description_en' => ! empty($validated['description'])
                ? $translationService->translate($validated['description'])
                : null,
            'images' => $imagePaths ?: null,
            'image_positions' => $validated['image_positions'] ?? null,
            'order' => $validated['order'],
        ]);

        return redirect()->route('cms.features.pages.show', [$feature, $page])
            ->with('success', __('cms.feature_pages.flash.section_updated'));
    }

    /**
     * Delete a section.
     */
    public function destroySection(Feature $feature, FeaturePage $page, FeaturePageSection $section)
    {
        $this->deleteSectionImages($section);
        $section->delete();

        return redirect()->route('cms.features.pages.show', [$feature, $page])
            ->with('success', __('cms.feature_pages.flash.section_deleted'));
    }

    /**
     * Public: show feature page with sections (paginated).
     */
    public function publicShow(Feature $feature, ?int $pageNum = null)
    {
        $feature->load('parent');
        $pages = $feature->pages()->withCount('sections')->orderBy('order')->get();

        if ($pages->isEmpty()) {
            abort(404);
        }

        $pageNum = $pageNum ?? 1;
        $currentPage = $pages->values()->get($pageNum - 1);

        if (! $currentPage) {
            abort(404);
        }

        $currentPage->load('sections');

        return view('pages.feature', [
            'feature' => $feature,
            'pages' => $pages,
            'currentPage' => $currentPage,
            'currentPageNum' => $pageNum,
            'totalPages' => $pages->count(),
        ]);
    }

    /**
     * Public: show feature page by path (e.g., /pameran/tetap).
     */
    public function publicShowByPath(Request $request)
    {
        $path = '/' . $request->path;
        $feature = Feature::where('path', $path)->firstOrFail();
        $feature->loadCount('pages');

        // Virtual rooms feature — show dedicated 360° tour page
        if (method_exists($feature, 'virtualRooms')) {
            $virtualRooms = $feature->virtualRooms()->withCount('hotspots')->with('hotspots')->get();
            if ($virtualRooms->isNotEmpty()) {
                return view('pages.virtual_tour', compact('feature', 'virtualRooms'));
            }
        }

        if ($feature->pages_count > 0) {
            return $this->publicShow($feature, 1);
        }

        return view('pages.feature', compact('feature'));
    }

    private function deleteSectionImages(FeaturePageSection $section): void
    {
        if ($section->images) {
            foreach ($section->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
    }
}
