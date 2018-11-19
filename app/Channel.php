<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function threads()
    {
        $this->hasMany(Thread::class);
    }
}
