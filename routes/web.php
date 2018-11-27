<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

// Route::match(['get', 'post'], '/system-cpanel', 'AdminController@login');
Route::get('/system-cpanel', 'AdminController@login')->name('get.login');
Route::post('/system-cpanel', 'AdminController@postLogin')->name('post.login');
Route::prefix('/system-cpanel')->middleware('auth')->group(function () {
    Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::get('/settings', 'AdminController@settings');
    Route::get('/check-pwd', 'AdminController@checkPass');
    Route::match(['get', 'post'], '/update-pwd', 'AdminController@updatePassword');

    // Categories Routes (Admin)
    Route::resource('category', 'CategoryController');

    // Products Routes (Admin)
    Route::resource('product', 'ProductController');
    Route::get('ajaxGetProducts', 'AjaxDataController@ajaxGetProducts')->name('ajax.getProducts');

    // Products Attributes Route (Admin)
    Route::get('/add-attributes/{id}', 'ProductController@getAddAttributes')->name('get.add-attributes');
    Route::post('/add-attributes/{id}', 'ProductController@postAddAttributes')->name('post.add-attributes');
    Route::post('/edit-attribute/{id}', 'ProductController@postEditAttribute')->name('post.edit-attribute');
    Route::post('/delete-attribute/{id}', 'ProductController@postDeleteAttribute')->name('post.delete-attribute');

    // Products Galleries Route (Admin)
    Route::get('/add-galleries/{id}', 'ProductController@getAddGalleries')->name('get.add-galleries');
    Route::post('/add-galleries/{id}', 'ProductController@postAddGalleries')->name('post.add-galleries');
    Route::post('/delete-galleries/{id}', 'ProductController@postDeleteGallery')->name('post.delete-gallery');
});
Route::get('/logout', 'AdminController@logout');

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
// Homepage route (Frontend)
Route::get('/', 'FrontendController@homepage')->name('homepage');

// Show products By Category route (Frontend)
Route::get('/danh-muc/{slug}.html', 'FrontendController@getProductsByCategory')->name('get.products_by_category');

// Show product detail
Route::get('/{slug}-product{id}.html', 'FrontendController@getProductDetail')->name('get.product_detail')->where(['slug' => '[a-zA-Z-0-9]+', 'id' => '[0-9]*']);

// Get product attribute
Route::get('/get-attribute', 'FrontendController@getProductAttribute')->name('get.attribute');

// Add to card
Route::post('/add-cart', 'FrontendController@postAddCart')->name('post.add_cart');

// Card route (Frontend)
Route::get('/cart.html', 'FrontendController@getCart')->name('get.cart');