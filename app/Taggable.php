<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag_id',
        'taggable_id',
    	'taggable_type',
    	'created_at',
    	'updated_at',
    ];
}
