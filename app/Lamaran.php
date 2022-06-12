<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'pelamar_id',
    	'pekerjaan_id',
    	'files',
    	'created_at',
    	'updated_at',
        'diverifikasi',
        'diverifikasi_pada',
        'diverifikasi_oleh',
        'catatan_diverifikasi',
        'diterima',
        'diterima_pada',
        'diterima_oleh',
        'alasan_diterima',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'diverifikasi' => 'boolean',
        'diterima' => 'boolean',
    ];

    /**
     * Get the pelamar of model.
     */
    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class);
    }

    /**
     * Get the pekerjaan of model.
     */
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    /**
     * Get the saw_hasil of model.
     */
    public function sawHasils()
    {
        return $this->hasMany(SawHasil::class);
    }

    /**
     * Get the pemverifikasi of model.
     */
    public function diverifikasiOleh()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    /**
     * Get the penerima of model.
     */
    public function diterimaOleh()
    {
        return $this->belongsTo(User::class, 'diterima_oleh');
    }
}
