<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $images = $this->getUserImages();
        return view('dashboard', compact('images'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            
            // Get existing images from session
            $images = $this->getUserImages();
            
            // Add new image
            $images[] = [
                'path' => $path,
                'url' => Storage::url($path),
                'name' => $request->file('image')->getClientOriginalName(),
                'uploaded_at' => now()->toDateTimeString(),
            ];
            
            // Store back in session
            session(['user_images_' . auth()->id() => $images]);

            return back()->with('success', 'Image uploaded successfully!');
        }

        return back()->with('error', 'Failed to upload image.');
    }

    private function getUserImages()
    {
        return session('user_images_' . auth()->id(), []);
    }
}

