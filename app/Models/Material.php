<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi ke Sub-poin
    public function steps()
    {
        return $this->hasMany(MaterialStep::class);
    }

    // Helper untuk menghitung progress persen
    public function getProgressAttribute()
    {
        $total = $this->steps->count();
        if ($total == 0) return 0;
        
        $completed = $this->steps->where('status', 'completed')->count();
        return round(($completed / $total) * 100);
    }
}