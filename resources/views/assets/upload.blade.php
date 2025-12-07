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