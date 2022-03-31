<?php

namespace App\Models;

class Upload extends \Eloquent
{
    /**
     * @type string
     */
    protected $table = "uploads";

    /**
     * @type array
     */
    protected $guarded = ['id'];

    /**
     * @type array
     */
    protected $fillable = [];

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

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }
}
