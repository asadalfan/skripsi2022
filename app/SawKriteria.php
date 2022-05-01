<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SawKriteria extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'nama',
        'bobot',
    	'created_at',
    	'updated_at',
    ];
}
