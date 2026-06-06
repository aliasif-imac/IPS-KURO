<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    // Force Laravel to look for the correct table name
    protected $table = 'alumni';

    // Allow mass assignment safely
    protected $guarded = [];
}