<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuzzy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'min',
        'max',
        'nilai',
    	'created_at',
    	'updated_at',
    ];
}
