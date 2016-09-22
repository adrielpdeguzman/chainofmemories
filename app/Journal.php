<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    /**
     * Get the user that owns the journal entry.
     *
     * @return  Illuminate\Database\Eloquent\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
