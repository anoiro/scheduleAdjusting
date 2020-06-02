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

Route::get('/', function () {
    return view('welcome');
});

Route::get('tests/test', 'TestController@index');
//testsフォルダにtestファイルを作ってTestControllerファイルが持つindex関数をルーティングする
//具体的にはtests/testにアクセスしたらTestControllerのindex関数に飛ぶように仕組まれている

Route::get('shops/index', 'ShopController@index');

//restにはindex,create,
Route::group(['prefix' => 'contact', 'middleware' => 'auth'], function () {
    //index
    Route::get('index', 'ContactFormController@index')->name('contact.index');
    //create
    Route::get('create', 'ContactFormController@create')->name('contact.create');
    //store
    Route::post('store', 'ContactFormController@store')->name('contact.store');
    //show/{id}とかくと主キーと紐づけてアクセスできる
    Route::get('show/{id}', 'ContactFormController@show')->name('contact.show');
    //edit
    Route::get('edit/{id}', 'ContactFormController@edit')->name('contact.edit');
    //update
    Route::post('update/{id}', 'ContactFormController@update')->name('contact.update');
    //destroy
    Route::post('destroy/{id}', 'ContactFormController@destroy')->name('contact.destroy');
});

//RESTの書き方。
// Route::resource('contacts', 'ContactFormController')->only([
//     'index', 'show'
// ]);

//アカウントを作ってログイン認証したらshow()とかindex()とかを実行できるようにしておく
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/////////////////Portfolio1/////////////////
//restにはindex,create,
Route::get('portfolio1/index','Portfolio1Controller@index')->name('portfolio1.index');
Route::get('portfolio1/create','Portfolio1Controller@create')->name('portfolio1.create');
Route::post('portfolio1/store','Portfolio1Controller@store')->name('portfolio1.store');
Route::get('portfolio1/show/{id}','Portfolio1Controller@show')->name('portfolio1.show');
Route::get('portfolio1/edit/{id}','Portfolio1Controller@edit')->name('portfolio1.edit');
Route::post('portfolio1/update/{id}','Portfolio1Controller@update')->name('portfolio1.update');
Route::post('portfolio1/destroy/{id}','Portfolio1Controller@destroy')->name('portfolio1.destroy');
Route::get('portfolio1/createImg','Portfolio1Controller@createImg')->name('portfolio1.createImg');
Route::post('portfolio1/storeImg','Portfolio1Controller@storeImg')->name('portfolio1.storeImg');

//Route::get('portfolio1par/index','Portfolio1ParController@index');
Route::group(['prefix' => 'portfolio1par', 'middleware' => 'auth'], function () {
    //index
    Route::get('index', 'Portfolio1ParController@index')->name('portfolio1.index');
    // //create
    // Route::get('create', 'ContactFormController@create')->name('contact.create');
    // //store
    // Route::post('store', 'ContactFormController@store')->name('contact.store');
    // //show/{id}とかくと主キーと紐づけてアクセスできる
    // Route::get('show/{id}', 'ContactFormController@show')->name('contact.show');
    // //edit
    // Route::get('edit/{id}', 'ContactFormController@edit')->name('contact.edit');
    // //update
    // Route::post('update/{id}', 'ContactFormController@update')->name('contact.update');
    // //destroy
    // Route::post('destroy/{id}', 'ContactFormController@destroy')->name('contact.destroy');
});