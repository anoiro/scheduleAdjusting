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
//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

/////////////////Portfolio1/////////////////
//Participants User
Route::namespace('User')->prefix('user')->name('user.')->group(function () {
    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'reset'    => false,
        'verify'   => false
    ]);
    // ログイン認証後
    Route::middleware('auth:user')->group(function () {
        // TOPページ
        Route::resource('home', 'HomeController', ['only' => 'index']);
    });
});
//Experimenter
Route::namespace('Exper')->prefix('exper')->name('exper.')->group(function () {
    //print(100);
    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'reset'    => false,
        'verify'   => false
    ]);
    // ログイン認証後
    Route::middleware('auth:exper')->group(function () {
        // TOPページ
        Route::resource('home', 'HomeController', ['only' => 'index']);
    });
});

//Participant用のページ
Route::group(['prefix' => 'portfolio1par', 'middleware' => 'auth:user'], function () {
    //index
    Route::get('index', 'Portfolio1ParController@index')->name('portfolio1par.index');
    //create
    Route::get('create/{id}', 'Portfolio1ParController@create')->name('portfolio1par.create');
    //store
    Route::post('store/{id}', 'Portfolio1ParController@store')->name('portfolio1par.store');
    //show/{id}とかくと主キーと紐づけてアクセスできる
    Route::get('show/{id}', 'Portfolio1ParController@show')->name('portfolio1par.show');
    // //edit
    // Route::get('edit/{id}', 'Portfolio1Controller@edit')->name('portfolio1.edit');
    // //update
    // Route::post('update/{id}', 'Portfolio1Controller@update')->name('portfolio1.update');
    // //destroy
    // Route::post('destroy/{id}', 'Portfolio1Controller@destroy')->name('portfolio1.destroy');
    // //createImg
    // Route::get('createImg','Portfolio1Controller@createImg')->name('portfolio1.createImg');
    // //storeImg
    // Route::post('storeImg','Portfolio1Controller@storeImg')->name('portfolio1.storeImg');
});

//Experimeten用のページ
Route::group(['prefix' => 'portfolio1', 'middleware' => 'auth:exper'], function () {
    //index
    Route::get('index', 'Portfolio1Controller@index')->name('portfolio1.index');
    //create
    Route::get('create', 'Portfolio1Controller@create')->name('portfolio1.create');
    //store
    Route::post('store', 'Portfolio1Controller@store')->name('portfolio1.store');
    //show/{id}とかくと主キーと紐づけてアクセスできる
    Route::get('show/{id}', 'Portfolio1Controller@show')->name('portfolio1.show');
    //edit
    Route::get('edit/{id}', 'Portfolio1Controller@edit')->name('portfolio1.edit');
    //update
    Route::post('update/{id}', 'Portfolio1Controller@update')->name('portfolio1.update');
    //destroy
    Route::post('destroy/{id}', 'Portfolio1Controller@destroy')->name('portfolio1.destroy');
    //createImg
    Route::get('createImg','Portfolio1Controller@createImg')->name('portfolio1.createImg');
    //storeImg
    Route::post('storeImg','Portfolio1Controller@storeImg')->name('portfolio1.storeImg');
});

Auth::routes();
Auth::user();
Auth::id();
//Route::get('/home', 'HomeController@index')->name('home');