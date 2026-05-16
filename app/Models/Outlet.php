<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_outlet'; // Beritahu Laravel PK kita bukan 'id'
    protected $guarded = []; // Izinkan semua kolom diisi data
}
