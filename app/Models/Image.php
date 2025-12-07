<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['user_id', 'original_path', 'variants', 'status', 'error'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'variants' => 'array',
    ];


    public function getThumbUrlAttribute()
    {
        return Storage::url($this->variants['thumb']);
    }

    public function getMediumUrlAttribute()
    {
        return Storage::url($this->variants['medium']);
    }
    
    public function getLargeUrlAttribute()
    {
        return Storage::url($this->variants['large']);
    }

    public function getOriginalUrlAttribute()
    {
        if (!$this->original_path) {
            return null;
        }
        
        return asset('storage/' . $this->original_path);
    }
}
