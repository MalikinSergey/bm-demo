<?php

use Stringy\StaticStringy;

function bm_slug($string, $replace = "-")
{
    $string = preg_replace("/(svg|png|jpg)/i", "", $string);

    $pattern = "/[\-_\.\;\:\&\,\/]/u";

    $string = preg_replace($pattern, $replace, $string);

    $string = StaticStringy::delimit($string, $replace);

    $string = trim($string, $replace);

    return $string;
}

function bm_log($message, $object = null, $data = null, $level = 'info')
{
    \Log::driver('db')->log($level, $message, ['object' => $object, 'data' => $data]);
}

function bm_zip($source, $destination, $include_dir = false)
{
//    dd($source, $destination);

    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    if (file_exists($destination)) {
        unlink($destination);
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }
    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        if ($include_dir) {
            $arr = explode("/", $source);
            $maindir = $arr[count($arr) - 1];

            $source = "";
            for ($i = 0; $i < count($arr) - 1; $i++) {
                $source .= '/' . $arr[$i];
            }

            $source = substr($source, 1);

            $zip->addEmptyDir($maindir);
        }

        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..'))) {
                continue;
            }

            $file = realpath($file);

            if (is_dir($file) === true) {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            } else {
                if (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        }
    } else {
        if (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }
    }

    return $zip->close();
}

function user()
{
    return auth()->user();
}