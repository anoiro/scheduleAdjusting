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
        // Route::resource('home', 'HomeController', ['only' => 'index']);
        // Route::resource('index', 'Portfolio1ParController@index');
        Route::resource('index', 'User\ExperimentationController@index');
    });
});
//Experimenter
Route::namespace('Exper')->prefix('exper')->name('exper.')->group(function () {
    // ログイン認証関連
    Auth::routes([
        'register' => true,
        'reset'    => false,
        'verify'   => false
    ]);
    // ログイン認証後
    Route::middleware('auth:exper')->group(function () {
        // TOPページ
        //Route::resource('home', 'HomeController', ['only' => 'index']);
        // Route::resource('index', 'Portfolio1Controller@index');
        Route::resource('index', 'Exper\ExperimentationController@index');
    });
});

//Participant用のページ
Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function () {
    //index
    // Route::get('index', 'Portfolio1ParController@index')->name('portfolio1par.index');
    Route::get('index', 'User\ExperimentationController@index')->name('user.index');
    //create
    // Route::get('create/{exp}', 'Portfolio1ParController@create')->name('portfolio1par.create');
    Route::get('create/{exp}', 'User\ExperimentationController@create')->name('user.create');
    //store
    // Route::post('store/{participantID}', 'Portfolio1ParController@store')->name('portfolio1par.store');
    Route::post('store/{participantID}', 'User\ExperimentationController@store')->name('user.store');
    //show/{id}とかくと主キーと紐づけてアクセスできる
    // Route::get('show/{exp}', 'Portfolio1ParController@show')->name('portfolio1par.show');
    Route::get('show/{expID}', 'User\ExperimentationController@show')->name('user.show');
    //edit
    // Route::get('edit/{exp}', 'Portfolio1ParController@edit')->name('portfolio1par.edit');
    Route::get('edit/{expID}', 'User\ExperimentationController@edit')->name('user.edit');
    //update
    // Route::post('update/{participantID}', 'Portfolio1ParController@update')->name('portfolio1par.update');
    Route::post('update/{participantID}', 'User\ExperimentationController@update')->name('user.update');
    //destroy
    // Route::post('destroy/{participantID}{exp}', 'Portfolio1ParController@destroy')->name('portfolio1par.destroy');
    Route::post('destroy/{participantID}{exp}', 'User\ExperimentationController@destroy')->name('user.destroy');
});

//Experimeter用のページ
Route::group(['prefix' => 'exper', 'middleware' => 'auth:exper'], function () {
    //index
    // Route::get('index', 'Portfolio1Controller@index')->name('portfolio1.index');
    Route::get('index', 'Exper\ExperimentationController@index')->name('exper.index');
    //create
    // Route::get('create', 'Portfolio1Controller@create')->name('portfolio1.create');
    Route::get('create', 'Exper\ExperimentationController@create')->name('exper.create');
    //store
    // Route::post('store', 'Portfolio1Controller@store')->name('portfolio1.store');
    Route::post('store', 'Exper\ExperimentationController@store')->name('exper.store');
    //show/{id}とかくと主キーと紐づけてアクセスできる
    // Route::get('show/{exp}', 'Portfolio1Controller@show')->name('portfolio1.show');
    Route::get('show/{expID}', 'Exper\ExperimentationController@show')->name('exper.show');
    //edit
    // Route::get('edit/{exp}', 'Portfolio1Controller@edit')->name('portfolio1.edit');
    Route::get('edit/{exp}', 'Exper\ExperimentationController@edit')->name('exper.edit');
    //update
    // Route::post('update/{id}', 'Portfolio1Controller@update')->name('portfolio1.update');
    Route::post('update/{id}', 'Exper\ExperimentationController@update')->name('exper.update');
    //destroy
    // Route::post('destroy/{exp}', 'Portfolio1Controller@destroy')->name('portfolio1.destroy');
    Route::post('destroy/{exp}', 'Exper\ExperimentationController@destroy')->name('exper.destroy');
    //createImg
    // Route::get('createImg', 'Portfolio1Controller@createImg')->name('portfolio1.createImg');
    Route::get('createImg', 'Exper\ExperimentationController@createImg')->name('exper.createImg');
    //storeImg
    // Route::post('storeImg', 'Portfolio1Controller@storeImg')->name('portfolio1.storeImg');
    Route::post('storeImg', 'Exper\ExperimentationController@storeImg')->name('exper.storeImg');
    //createDate
    // Route::get('createDate/{exp}', 'Portfolio1Controller@createDate')->name('portfolio1.createDate');
    Route::get('createDate/{exp}', 'Exper\ExperimentationController@createDate')->name('exper.createDate');
    //storeDate
    // Route::post('storeDate', 'Portfolio1Controller@storeDate')->name('portfolio1.storeDate');
    Route::post('storeDate', 'Exper\ExperimentationController@storeDate')->name('exper.storeDate');
});