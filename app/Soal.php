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
        'user_id',
        'pekerjaan_id',
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

    /**
     * Get the user of model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pekerjaan of model.
     */
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }
}
