<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SawPeringkat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'lamaran_id',
    	'nilai',
        'nilai_fuzzy',
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
}
