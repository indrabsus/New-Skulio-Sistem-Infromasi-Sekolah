<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal_agenda','kegiatan_agenda','partner','materi','hasil_kegiatan','level','publish'
    ];
}
