<?php

namespace App\Models;

class Tag extends \Eloquent
{
    /**
     * @type string
     */
    protected $table = "tags";

    /**
     * @type array
     */
    protected $guarded = ['id'];

    /**
     * @type array
     */
    protected $fillable = ['name', 'slug', 'data', 'position'];

    /**
     * @type array
     */
    protected $casts = [];

    /**
     * @type array
     */
    protected $dates = [];

    /**
     * @type bool
     */
    public $timestamps = true;

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

}
