<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // Agar semua kolom bisa diisi

public function daily_activities() {
    return $this->hasMany(DailyActivity::class);
}
public function user() {
    return $this->belongsTo(User::class);
}
}
