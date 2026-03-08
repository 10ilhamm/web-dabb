<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Virtual3dRoom;
use App\Models\Virtual3dMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Virtual3dRoomController extends Controller
{
    public function index(Feature $feature)
    {
        $virtual3dRooms = $feature->virtual3dRooms()->latest()->get();
        return view('cms.features.virtual_3d_rooms.index', compact('feature', 'virtual3dRooms'));
    }

    public function create(Feature $feature)
    {
        $allRooms = $feature->virtual3dRooms()->get();
        return view('cms.features.virtual_3d_rooms.create', compact('feature', 'allRooms'));
    }

    public function store(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'wall_color' => 'nullable|string',
            'floor_color' => 'nullable|string',
            'ceiling_color' => 'nullable|string',
            'door_link_type' => 'nullable|in:none,feature,room,url',
            'door_target' => 'nullable|string',
            'door_label' => 'nullable|string',
        ]);

        $room = new Virtual3dRoom();
        $room->feature_id = $feature->id;
        $room->name = $validated['name'];
        $room->description = $validated['description'];
        $room->wall_color = $validated['wall_color'] ?? '#e5e7eb';
        $room->floor_color = $validated['floor_color'] ?? '#8B7355';
        $room->ceiling_color = $validated['ceiling_color'] ?? '#f5f5f5';
        $room->door_link_type = $validated['door_link_type'] ?? 'none';
        $room->door_target = $validated['door_target'] ?? null;
        $room->door_label = $validated['door_label'] ?? null;

        if ($request->hasFile('thumbnail')) {
            $room->thumbnail_path = $request->file('thumbnail')->store('virtual_3d_rooms/thumbnails', 'public');
        } elseif ($request->filled('auto_thumbnail')) {
            // Process base64 auto-thumbnail from html2canvas
            $imgData = $request->input('auto_thumbnail');
            if (preg_match('/^data:image\/(\w+);base64,/', $imgData, $type)) {
                $imgData = substr($imgData, strpos($imgData, ',') + 1);
                $imgData = base64_decode($imgData);
                
                $extension = strtolower($type[1]); // jpeg, png
                $fileName = 'thumbnail_' . Str::random(10) . '_' . time() . '.' . $extension;
                $path = 'virtual_3d_rooms/thumbnails/' . $fileName;
                
                Storage::disk('public')->put($path, $imgData);
                $room->thumbnail_path = $path;
            }
        }

        $room->save();

        return redirect()->route('cms.features.virtual_3d_rooms.edit', [$feature, $room])
            ->with('success', 'Ruangan Virtual 3D berhasil ditambahkan. Sekarang Anda bisa menambahkan media ke dinding ruangan.');
    }

    public function edit(Feature $feature, Virtual3dRoom $room)
    {
        $room->load('media');
        $allRooms = $feature->virtual3dRooms()->where('id', '!=', $room->id)->get();
        return view('cms.features.virtual_3d_rooms.edit', compact('feature', 'room', 'allRooms'));
    }

    public function update(Request $request, Feature $feature, Virtual3dRoom $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'wall_color' => 'nullable|string',
            'floor_color' => 'nullable|string',
            'ceiling_color' => 'nullable|string',
            'door_link_type' => 'nullable|in:none,feature,room,url',
            'door_target' => 'nullable|string',
            'door_label' => 'nullable|string',
        ]);

        $room->name = $validated['name'];
        $room->description = $validated['description'];
        $room->wall_color = $validated['wall_color'] ?? '#e5e7eb';
        $room->floor_color = $validated['floor_color'] ?? '#8B7355';
        $room->ceiling_color = $validated['ceiling_color'] ?? '#f5f5f5';
        $room->door_link_type = $validated['door_link_type'] ?? 'none';
        $room->door_target = $validated['door_target'] ?? null;
        $room->door_label = $validated['door_label'] ?? null;

        if ($request->hasFile('thumbnail')) {
            if ($room->thumbnail_path) {
                Storage::disk('public')->delete($room->thumbnail_path);
            }
            $room->thumbnail_path = $request->file('thumbnail')->store('virtual_3d_rooms/thumbnails', 'public');
        } elseif ($request->filled('auto_thumbnail')) {
            // Process base64 auto-thumbnail from html2canvas only if no manual file is uploaded
            $imgData = $request->input('auto_thumbnail');
            if (preg_match('/^data:image\/(\w+);base64,/', $imgData, $type)) {
                $imgData = substr($imgData, strpos($imgData, ',') + 1);
                $imgData = base64_decode($imgData);
                
                if ($room->thumbnail_path) {
                    Storage::disk('public')->delete($room->thumbnail_path);
                }
                
                $extension = strtolower($type[1]); // jpeg, png
                $fileName = 'thumbnail_' . Str::random(10) . '_' . time() . '.' . $extension;
                $path = 'virtual_3d_rooms/thumbnails/' . $fileName;
                
                Storage::disk('public')->put($path, $imgData);
                $room->thumbnail_path = $path;
            }
        }

        $room->save();

        return redirect()->route('cms.features.virtual_3d_rooms.index', $feature)
            ->with('success', 'Ruangan Virtual 3D berhasil diperbarui.');
    }

    public function destroy(Feature $feature, Virtual3dRoom $room)
    {
        if ($room->thumbnail_path) {
            Storage::disk('public')->delete($room->thumbnail_path);
        }
        
        foreach($room->media as $media) {
            Storage::disk('public')->delete($media->file_path);
        }

        $room->delete();

        return redirect()->route('cms.features.virtual_3d_rooms.index', $feature)
            ->with('success', 'Ruangan Virtual 3D berhasil dihapus.');
    }

    // Media Management
    public function uploadMedia(Request $request, Feature $feature, Virtual3dRoom $room)
    {
        $validated = $request->validate([
            'wall' => 'required|in:front,back,left,right',
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,webm|max:20480',
            'type' => 'required|in:image,video',
            'position_x' => 'required|numeric',
            'position_y' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        $path = $request->file('file')->store('virtual_3d_rooms/media', 'public');

        $media = new Virtual3dMedia();
        $media->virtual3d_room_id = $room->id;
        $media->wall = $validated['wall'];
        $media->type = $validated['type'];
        $media->file_path = $path;
        $media->position_x = $validated['position_x'];
        $media->position_y = $validated['position_y'];
        $media->width = $validated['width'];
        $media->height = $validated['height'];
        $media->save();

        return response()->json([
            'success' => true, 
            'media' => $media,
            'url' => asset('storage/' . $path)
        ]);
    }

    public function updateMediaPosition(Request $request, Feature $feature, Virtual3dRoom $room, Virtual3dMedia $media)
    {
        $validated = $request->validate([
            'position_x' => 'required|numeric',
            'position_y' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        $media->update($validated);
        return response()->json(['success' => true]);
    }

    public function deleteMedia(Feature $feature, Virtual3dRoom $room, Virtual3dMedia $media)
    {
        Storage::disk('public')->delete($media->file_path);
        $media->delete();
        return response()->json(['success' => true]);
    }
}
