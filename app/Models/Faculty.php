<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    // Authorized mass-assignment array template
    protected $fillable = ['name',
        'designation',
        'qualification',
        'department',
        'type',              // <-- Add this line
        'lifecycle_status',  // <-- Add this line
        'sort_order',
        'image_path',
    ];

    protected $guarded = [];

    // Historical Record Log Link
    public function logs()
    {
        return $this->hasMany(FacultyLog::class)->orderBy('created_at', 'desc');
    }
}