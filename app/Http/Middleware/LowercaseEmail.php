<?php

namespace App\Http\Middleware;


use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Stringy\StaticStringy;

class LowercaseEmail extends TransformsRequest
{

    /**
     * Transform the given value.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if ($key === 'email') {
            return StaticStringy::toLowerCase($value);
        }
        else{
            return $value;
        }
    }
}
