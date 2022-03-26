<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    /**
     * Get all of the pekerjaans that are assigned this tag.
     */
    public function pekerjaans()
    {
        return $this->morphedByMany(Pekerjaan::class, 'taggable');
    }
}
