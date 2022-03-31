<?php

namespace App\Models;

class Category extends \Eloquent
{
    /**
     * @type string
     */
    protected $table = "categories";

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
}
