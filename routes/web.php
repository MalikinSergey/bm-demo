<?php

use App\Mail\ContactFormMessage;
use Illuminate\Support\Facades\Route;

#####################

Route::get(
    '/test',

    function () {


        \Mail::to(['malikin.sergey.1988@gmail.com', 'malikin.sergey@yandex.ru'])->send(new \App\Mail\Test());



    }
);

# payments

Route::any('/payment/2co/ins', 'Payment\TwoCheckoutController@ins')->name('payment.2co.ins');
Route::any('/payment/2co/ipn', 'Payment\TwoCheckoutController@ins')->name('payment.2co.ins');


######################

Route::get('/', 'Website\IndexController@index')->name('website.index');

# about

Route::view('/about', 'website.about.about')->name('website.about');

# legal pages

Route::view('/legal/terms', 'website.legal.terms')->name('website.legal.terms');
Route::view('/legal/privacy', 'website.legal.privacy')->name('website.legal.privacy');
Route::view('/legal/payments', 'website.legal.payments')->name('website.legal.payments');
Route::view('/legal/refunds', 'website.legal.refunds')->name('website.legal.refunds');
Route::view('/legal/delivery', 'website.legal.delivery')->name('website.legal.delivery');
Route::view('/legal/licenses', 'website.legal.licenses')->name('website.legal.licenses');

# contact
Route::get('/contact', 'Website\ContactController@form')->name('website.contact.form');
Route::post('/contact', 'Website\ContactController@send')->name('website.contact.send');
Route::get('/contact-success', 'Website\ContactController@success')->name('website.contact.success');

# search

Route::get('/searching', 'Website\SearchController@searching')->name('website.search.searching');
Route::get('/search/{query}', 'Website\SearchController@search')->name('website.search.search');

# register and login
Route::get('/register', 'Website\User\RegisterController@registerForm')->name('website.user.register_form');
Route::post('/register', 'Website\User\RegisterController@register')->name('website.user.register');
Route::get('/verify-email/{hash}', 'Website\User\RegisterController@verifyEmail')->name('website.user.verify_email');
Route::get('/registered', 'Website\User\RegisterController@registered')->name('website.user.registered');

Route::post('/sign-in', 'Website\User\LoginController@login')->name('website.user.login');
Route::post('/sign-out', 'Website\User\LoginController@logout')->name('website.user.logout');

#
Route::get('/families', 'Website\FamilyController@index')->name('website.family.index');
Route::get('/illustrations', 'Website\FamilyController@illustrations')->name('website.family.illustrations');

Route::get('/assets/{family}/{asset}.svg', 'Website\AssetController@inline')->name('website.asset.inline');
//Route::get('/assets/{family}/{asset}.{type}', 'Website\AssetController@inline');

# familiy
Route::get('/family/{family}', 'Website\FamilyController@show')->name('website.family.show');

Route::post('/family/{family}/buy', 'Website\FamilyController@buy')->name('website.family.buy');

Route::get('/family/{family}/download', 'Website\FamilyController@download')->name('website.family.download');

#pack

Route::get('/family/{family}/pack/{pack}', 'Website\PackController@show')->name('website.pack.show');
Route::post('/family/{family}/pack/{pack}/buy', 'Website\PackController@buy')->name('website.pack.buy');
Route::get('/downloads/{family}/pack/{pack}.zip', 'Website\PackController@download')->name('website.pack.download');

# asset

Route::get('/family/{family}/asset/{asset}', 'Website\AssetController@show')->name('website.asset.show');

Route::post('/family/{family}/asset/{asset}/buy', 'Website\AssetController@buy')->name('website.asset.buy');

Route::get('/downloads/{family}/asset/{asset}.zip', 'Website\AssetController@download')->name('website.asset.download');

Route::view('/dashboard-login', 'dashboard.login');

Route::post(
    '/dashboard-login',

    function () {
        $result = app('littlegatekeeper')->attempt(request()->only('username', 'password'));

        if ($result) {
            return redirect('/dashboard');
        } else {
            return back()->withErrors(['credentials' => 'Неверное имя пользователя или пароль']);
        }
    }
);

Route::group(
    ['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['littlegatekeeper']],
    function () {
        Route::view('/', 'dashboard.welcome');

        Route::resource('family', 'FamilyController');

        Route::resource('pack', 'PackController');

        Route::get('asset/add-multiple/{id}', 'AssetController@addMultiple')->name('asset.add_multiple');
        Route::post('asset/store-multiple', 'AssetController@storeMultiple')->name('asset.store_multiple');
        Route::get('asset/edit-multiple', 'AssetController@editMultiple')->name('asset.edit_multiple');
        Route::post('asset/update-multiple', 'AssetController@updateMultiple')->name('asset.update_multiple');
        Route::post('asset/update-multiple-prices', 'AssetController@updateMultiplePrices')->name('asset.update_multiple_prices');
        Route::resource('asset', 'AssetController');
    }
);

//require __DIR__ . '/auth.php';


