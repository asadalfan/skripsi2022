<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
    	'description',
    	'address',
    	'created_at',
    	'updated_at',
    ];

    /**
     * Get all of the tags for the post.
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
}
