<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_assignment';
    protected $guarded = [];

    // Relasi 1: Tugas ini untuk Toko mana?
    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'id_outlet', 'id_outlet');
    }

    // Relasi 2: Siapa Surveyor yang ngerjain?
    public function surveyor()
    {
        return $this->belongsTo(User::class, 'id_user_surveyor', 'id');
    }

    // Relasi 3: Siapa Tukang Pasang yang ngerjain?
    public function pemasang()
    {
        return $this->belongsTo(User::class, 'id_user_pemasang', 'id');
    }
}
