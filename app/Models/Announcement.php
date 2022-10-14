<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kegiatan','tempat_kegiatan','waktu_kegiatan','pengirim'
    ];
}
