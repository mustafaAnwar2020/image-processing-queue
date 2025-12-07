@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
@endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-[#706f6c] dark:text-[#A1A09A]">Upload and manage your images</p>
    </div>

    <!-- Upload Section -->
    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg p-8 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-[#1b1b18] dark:text-[#EDEDEC]">Upload Image</h2>
        
        <form method="POST" action="{{ route('dashboard.upload') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>
                <label for="image" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                    Choose Image
                </label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    accept="image/*"
                    required
                    class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] @error('image') border-red-500 @enderror"
                >
                @error('image')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">Max file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF, WEBP</p>
            </div>

            <button 
                type="submit" 
                class="bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] py-2 px-6 rounded-sm hover:bg-[#706f6c] dark:hover:bg-[#A1A09A] transition-colors font-medium"
            >
                Upload Image
            </button>
        </form>
    </div>

    <!-- Images Gallery -->
    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg p-8">
        <h2 class="text-xl font-semibold mb-4 text-[#1b1b18] dark:text-[#EDEDEC]">Your Images</h2>
        

        @if(empty($userImages))
            <div class="text-center py-12">
                <p class="text-[#706f6c] dark:text-[#A1A09A]">No images uploaded yet. Upload your first image above!</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach(array_reverse($userImages) as $image)
                    <div class="relative group">
                        <div class="aspect-square overflow-hidden rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                            <img 
                                src="{{ Storage::url($image['original_path']) }}" 
                                alt="{{ $image['name'] ?? 'Uploaded image' }}"
                                class="w-full h-full object-cover"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect fill=\'%23ddd\' width=\'100\' height=\'100\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\'%3EImage%3C/text%3E%3C/svg%3E'"
                            >
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] truncate">{{ $image['name'] ?? 'Image' }}</p>
                            @if(isset($image['uploaded_at']))
                                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    {{ \Carbon\Carbon::parse($image['uploaded_at'])->format('M d, Y') }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

