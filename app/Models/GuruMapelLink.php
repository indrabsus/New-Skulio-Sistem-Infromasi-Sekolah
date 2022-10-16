<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMapelLink extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_guru','id_mapel'
    ];
}
