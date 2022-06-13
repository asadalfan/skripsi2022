<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'perusahaan_id',
        'user_id',
    	'name',
    	'description',
    	'created_at',
    	'updated_at',
        'diverifikasi',
        'diverifikasi_pada',
        'diverifikasi_oleh',
        'catatan_diverifikasi',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'diverifikasi' => 'boolean',
    ];

    /**
     * Get all of the tags for the soal.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get the perusahaan of model.
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    /**
     * Get the owner of model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pemverifikasi of model.
     */
    public function diverifikasiOleh()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}
