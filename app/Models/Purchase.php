<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Purchase  extends MorphPivot
{
    public $timestamps = true;
    public $incrementing = true;
}