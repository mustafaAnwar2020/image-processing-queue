<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Jobs\ProcessImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $userImages = $this->getUserImages();

        return view('dashboard', compact('userImages'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');

            
            $images = $this->getUserImages();

            
            $images[] = [
                'path' => $path,
                'url' => Storage::url($path),
                'name' => $request->file('image')->getClientOriginalName(),
                'uploaded_at' => now()->toDateTimeString(),
            ];

            
            session(['user_images_' . Auth::id() => $images]);

            $image = Image::create([
                'user_id' => Auth::id(),
                'original_path' => $path,
                'status' => 'pending',
            ]);

            ProcessImage::dispatch($image->id);

            return back()->with('success', 'Image uploaded successfully!');
        }

        return back()->with('error', 'Failed to upload image.');
    }

    public function getImageStatus(Request $request)
    {
        $imageIds = $request->input('ids', []);
        
        $images = Image::where('user_id', Auth::id())
            ->whereIn('id', $imageIds)
            ->get(['id', 'status', 'variants'])
            ->keyBy('id');
        
        return response()->json($images);
    }

    private function getUserImages()
    {
        return Image::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
