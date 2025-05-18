<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'id_rekam';
    public $incrementing = false;
    protected $keyType = 'string';

protected $fillable = [
    'id_rekam',
    'id_pasien',
    'user_id',
    'tanggal_kunjungan',
    'keluhan',
    'biaya',
];


    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
