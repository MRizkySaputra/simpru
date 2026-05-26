<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;
    
    // Mengizinkan semua kolom diisi secara otomatis
    protected $guarded = ['id'];
}