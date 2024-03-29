<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_debit',
        'biaya_debit',
        'bulan_debit',
        'tahun_debit'
    ];
}
