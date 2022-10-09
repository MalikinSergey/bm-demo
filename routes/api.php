<?php

use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\PackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// assets
Route::get('/assets', [AssetController::class, 'index'])->name('api.asset.index');

//packs
Route::get('/packs', [PackController::class, 'index'])->name('api.pack.index');

