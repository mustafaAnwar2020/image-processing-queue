<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProcessImage implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    public $imageId;


    public $tries = 3;


    public function __construct(int $imageId)
    {
        $this->imageId = $imageId;
    }

    public function handle(): void
    {
        $image = Image::find($this->imageId);
        if (! $image) return;

        $disk = Storage::disk('public');


        $image->update(['status' => 'processing']);

        try {
            $originalPath = $image->original_path;
            $fullPath = $disk->path($originalPath);

            if (!file_exists($fullPath)) {
                throw new \Exception("Image file not found: {$fullPath}");
            }

            $sizes = [
                'thumb' => 150,
                'medium' => 600,
                'large' => 1200,
            ];

            $manager = new ImageManager(new Driver());
            $variants = [];

            foreach ($sizes as $key => $width) {
                $img = $manager->read($fullPath);
                $img->scale(width: $width);

                $variantPath = str_replace('images/', 'images/' . $key . '_', $originalPath);
                
                $disk->put($variantPath, (string)$img->encode());
                $variants[$key] = $variantPath;
            }

            $image->update(['variants' => $variants, 'status' => 'done']);
        } catch (\Exception $e) {
            $image->update(['status' => 'failed', 'error' => $e->getMessage()]);
            throw $e; 
        }
    }
}
