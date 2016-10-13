<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    /**
     * The accessors to append to the model's serialized form.
     *
     * @var array
     */
    protected $appends = [
        'day', 'volume',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'publish_date', 'created_at', 'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'publish_date', 'contents', 'events',
    ];

    /**
     * The models to be eager-loaded when querying Journal.
     *
     * @var array
     */
    protected $with = [
        'user',
    ];

    /**
     * Get the user that owns the journal entry.
     *
     * @return Illuminate\Database\Eloquent\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the day number for the journal based on publish_date.
     *
     * @return int
     */
    public function getDayAttribute()
    {
        $anniversaryDate = config('constants.anniversary_date');
        $day = $anniversaryDate->diffInDays($this->publish_date) + 1;

        if ($this->publish_date < $anniversaryDate) {
            return -1 * $day;
        }

        return $day;
    }

    /**
     * Get the volume number for the journal based on publish_date.
     *
     * @return int
     */
    public function getVolumeAttribute()
    {
        $anniversaryDate = config('constants.anniversary_date');

        if ($this->publish_date < $anniversaryDate) {
            return 1;
        }

        return $anniversaryDate->diffInMonths($this->publish_date) + 2;
    }
}
