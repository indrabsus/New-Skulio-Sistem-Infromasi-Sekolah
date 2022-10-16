<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama','instansi','keperluan','nohp','email','divisi'
    ];
}
