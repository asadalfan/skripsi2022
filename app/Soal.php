<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'saw_kriteria_id',
        'description',
    	'options',
    	'created_at',
    	'updated_at',
    ];

    /**
     * Get all of the tags for the soal.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get the saw kriteria of model.
     */
    public function sawKriteria()
    {
        return $this->belongsTo(SawKriteria::class);
    }
}
