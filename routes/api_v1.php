<?php

use App\Http\Controllers\Api\V1\FamilyController;

Route::get('/families/landing', [FamilyController::class, 'landing']);
Route::get('/family/{slug}', [FamilyController::class, 'show']);