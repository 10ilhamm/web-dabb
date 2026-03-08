<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function editFooter()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('cms.settings.footer', compact('settings'));
    }

    public function updateFooter(Request $request)
    {
        $data = $request->validate([
            'footer_title' => 'nullable|string',
            'footer_address' => 'nullable|string',
            'footer_phone' => 'nullable|string',
            'footer_email' => 'nullable|string',
            'footer_hours' => 'nullable|string',
            'footer_managed_by' => 'nullable|string',
            'footer_managed_by_sub' => 'nullable|string',
            'footer_facebook' => 'nullable|string',
            'footer_twitter' => 'nullable|string',
            'footer_instagram' => 'nullable|string',
            'footer_youtube' => 'nullable|string',
            'footer_map_embed' => 'nullable|string',
            'footer_menu_col1' => 'nullable|string',
            'footer_menu_col2' => 'nullable|string',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', __('cms.common.saved_successfully') ?? 'Pengaturan berhasil disimpan.');
    }
}
