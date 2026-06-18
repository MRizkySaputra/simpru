<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    // Ini mengubah data JSON dari database menjadi Array otomatis
    protected $casts = [
        'permissions' => 'array',
    ];

    // Menghitung jumlah user yang memiliki role ini
    public function users()
    {
        return $this->hasMany(User::class, 'role', 'name');
    }
}