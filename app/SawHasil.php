<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SawHasil extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'lamaran_id',
        'saw_kriteria_id',
    	'nilai',
    	'created_at',
    	'updated_at',
    ];

    /**
     * Get the lamaran of model.
     */
    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class);
    }

    /**
     * Get the saw kriteria of model.
     */
    public function sawKriteria()
    {
        return $this->belongsTo(SawKriteria::class);
    }
}
