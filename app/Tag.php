<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
    	'created_at',
    	'updated_at',
    ];
    
    /**
     * Get all of the pekerjaans that are assigned this tag.
     */
    public function pekerjaans()
    {
        return $this->morphedByMany(Pekerjaan::class, 'taggable');
    }

    /**
     * Get all of the soals that are assigned this tag.
     */
    public function soals()
    {
        return $this->morphedByMany(Soal::class, 'taggable');
    }
}
