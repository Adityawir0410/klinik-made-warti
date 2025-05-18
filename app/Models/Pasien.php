<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Model
{
    use HasFactory;

    // ✅ Nama tabel yang digunakan (default Laravel menebak jadi "pasiens")
    protected $table = 'pasien';

    // ✅ Kolom primary key (kamu pakai 'id_pasien', bukan 'id')
    protected $primaryKey = 'id_pasien';

    // ✅ Karena primary key bukan auto-increment (pakai kode manual, seperti 'P001')
    public $incrementing = false;
    protected $keyType = 'string';

    // ✅ Kolom-kolom yang boleh diisi secara massal (misal saat create/update)
    protected $fillable = [
        'id_pasien',
        'nama_pasien',
        'alamat_pasien'
    ];

    // (opsional) relasi ke tabel rekam_medis
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_pasien');
    }
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $last = static::orderBy('id_pasien', 'desc')->first();
        $num = $last ? (int)substr($last->id_pasien, 1) + 1 : 1;
        $model->id_pasien = 'P' . str_pad($num, 3, '0', STR_PAD_LEFT);
    });
}

}
