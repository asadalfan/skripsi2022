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
    	'user_id',
        'name',
    	'description',
    	'address',
    	'created_at',
    	'updated_at',
    ];

    /**
     * Get the owner of model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
