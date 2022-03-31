<?php

namespace App\Models;

interface Downloable
{

    public function downloadDir();

    public function downloadPath();

    public function downloadName();

}