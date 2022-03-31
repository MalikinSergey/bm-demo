<?php

namespace App\Support;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Archievable
{

    public function createArchive()
    {
        $dir = $this->downloadDir();

        $temp = \Str::random(6);

        Storage::disk('assets')->makeDirectory($temp);
        Storage::disk('assets')->makeDirectory($temp . "/svg");
        Storage::disk('assets')->makeDirectory($temp . "/png");

        if (static::class === Asset::class) {
            $assets = new Collection([$this]);
        } else {
            $assets = $this->assets;
        }

        foreach ($assets as $asset) {
            $nameSvg = $temp . "/" . $asset->slug . ".svg";
            $namePng = $temp . "/" . $asset->slug . ".png";

            if (!Storage::disk('assets')->exists($nameSvg)) {
                Storage::disk('assets')->copy($asset->path(), $temp . "/" . $asset->slug . ".svg");
            }

            if (!Storage::disk('assets')->exists($namePng)) {
                Storage::disk('assets')->copy($asset->path() . ".png", $temp . "/" . $asset->slug . ".png");
            }
        }

        # перемещаем png

        foreach (glob(Storage::disk('assets')->path($temp) . "/*.png") as $file) {
            $basename = basename($file);

            if ($basename === '.' || $basename === '..') {
                continue;
            }

            Storage::disk('assets')->move($temp . "/" . $basename, $temp . "/png/" . $basename);
        }

        # перемещаем свг

        foreach (glob(Storage::disk('assets')->path($temp) . "/*.svg") as $file) {
            $basename = basename($file);

            if ($basename === '.' || $basename === '..') {
                continue;
            }

            Storage::disk('assets')->move($temp . "/" . $basename, $temp . "/svg/" . $basename);
        }

        Storage::disk('downloads')->makeDirectory($dir);

        bm_zip(Storage::disk('assets')->path($temp), Storage::disk('downloads')->path($dir . "/" . $this->slug . ".zip"));

        Storage::disk('assets')->deleteDirectory($temp);
    }

}