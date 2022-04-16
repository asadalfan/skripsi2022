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
}
