<?php

namespace App\Helpers;

use Stringy\StaticStringy;

trait EnsureSlug
{

    public function ensureSlug($slugKey = 'slug', $nameKey = 'name')
    {
        if (!$this->{$slugKey}) {
            $this->{$slugKey} = bm_slug($this->{$nameKey});
        }
    }
}
