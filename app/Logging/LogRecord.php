<?php

namespace App\Logging;

class LogRecord extends \Eloquent
{
    /**
     * @type string
     */
    protected $table = "logs";

    /**
     * @type array
     */
    protected $guarded = ['id'];

    /**
     * @type array
     */
    protected $casts = ['object_state' => 'array', 'data' => 'array'];

    /**
     * @type bool
     */
    public $timestamps = true;
}