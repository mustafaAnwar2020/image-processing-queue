<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
