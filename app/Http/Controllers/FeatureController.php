<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the top-level features.
     */
    public function index()
    {
        $features = Feature::whereNull('parent_id')->withCount('subfeatures')->orderBy('order')->get();
        return view('cms.features.index', compact('features'));
    }

    /**
     * Store a newly created feature (or sub-feature).
     */
    public function store(Request $request, TranslationService $translationService)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'type'      => 'required|in:link,dropdown',
            'path'      => 'nullable|string|max:255',
            'order'     => 'required|integer|min:0',
            'parent_id' => 'nullable|exists:features,id',
        ]);

        $validated['name_en'] = $translationService->translate($validated['name']);

        Feature::create($validated);

        // If it's a sub-feature, redirect back to parent's show page
        if (!empty($validated['parent_id'])) {
            return redirect()->route('cms.features.show', $validated['parent_id'])
                ->with('success', 'Sub menu berhasil ditambahkan.');
        }

        return redirect()->route('cms.features.index')
            ->with('success', 'Fitur berhasil ditambahkan.');
    }

    /**
     * Show the detail of a feature.
     * - If path = '/' (Beranda): redirect to dedicated Beranda editor
     * - If type = dropdown: show sub-features list
     * - If type = link: show content editor
     */
    public function show(Feature $feature)
    {
        // Beranda has a dedicated structured editor
        if ($feature->path === '/' || strtolower($feature->name) === 'beranda') {
            return redirect()->route('cms.home.edit');
        }

        $feature->load('subfeatures');
        return view('cms.features.show', compact('feature'));
    }

    /**
     * Update the specified feature (name, type, path, order).
     */
    public function update(Request $request, Feature $feature, TranslationService $translationService)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'type'  => 'required|in:link,dropdown',
            'path'  => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['name_en'] = $translationService->translate($validated['name']);

        $feature->update($validated);

        return redirect()->route('cms.features.index')
            ->with('success', 'Fitur berhasil diperbarui.');
    }

    /**
     * Update the content of a link-type feature.
     */
    public function updateContent(Request $request, Feature $feature, TranslationService $translationService)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        $contentEn = null;
        if (!empty($validated['content'])) {
            $contentEn = $translationService->translate($validated['content']);
        }

        $feature->update([
            'content'    => $validated['content'],
            'content_en' => $contentEn,
        ]);

        return redirect()->route('cms.features.show', $feature)
            ->with('success', 'Konten halaman berhasil disimpan.');
    }

    /**
     * Remove the specified feature.
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();

        return redirect()->route('cms.features.index')
            ->with('success', 'Fitur berhasil dihapus.');
    }

    /**
     * Update a sub-feature (for dropdown detail page).
     */
    public function updateSub(Request $request, Feature $feature, TranslationService $translationService)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'path'  => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['name_en'] = $translationService->translate($validated['name']);

        $feature->update($validated);

        return redirect()->route('cms.features.show', $feature->parent_id)
            ->with('success', 'Sub fitur berhasil diperbarui.');
    }

    /**
     * Delete a sub-feature.
     */
    public function destroySub(Feature $feature)
    {
        $parentId = $feature->parent_id;
        $feature->delete();

        return redirect()->route('cms.features.show', $parentId)
            ->with('success', 'Sub fitur berhasil dihapus.');
    }
}
