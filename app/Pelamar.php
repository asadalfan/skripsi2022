<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    	'address',
    	'created_at',
    	'updated_at',
    ];

    /**
     * Get the user of model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
