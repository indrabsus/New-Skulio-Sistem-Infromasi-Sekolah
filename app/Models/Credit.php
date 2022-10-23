<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_credit',
        'biaya_credit',
        'bulan_credit',
        'tahun_credit'
    ];
}
