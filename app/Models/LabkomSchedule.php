<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabkomSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_guru','id_kelas','id_mapel','tempat','hari','jam_a','jam_b'
    ];
}
