<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SawHasilDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'saw_hasil_id',
        'soal_id',
    	'answer',
    	'created_at',
    	'updated_at',
    ];

    /**
     * Get the saw hasil of model.
     */
    public function sawHasil()
    {
        return $this->belongsTo(SawHasil::class);
    }

    /**
     * Get the soal of model.
     */
    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
