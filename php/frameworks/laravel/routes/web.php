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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('books','BookController');

Route::post ( 'books/search', function () {
   // $q = Input::get ( 'q' );
      $q = $request->input('q'); 
    
    if($q != ""){
    $book = Book::where ( 'isbn1', 'LIKE', '%' . $q . '%' )->orWhere ( 'title', 'LIKE', '%' . $q . '%' )->orWhere ( 'author', 'LIKE', '%' . $q . '%' )->orWhere ( 'publisher', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
    $pagination = $user->appends ( array (
                'q' => Input::get ( 'q' ) 
        ) );
    if (count ( $book ) > 0)
        return view ( 'books.index' )->withDetails ( $book )->withQuery ( $q );
    }
        return view ( 'books.index' )->withMessage ( 'No Details found. Try to search again !' );
} );


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('mongo', function(Request $request) {
    $collection = Mongo::get()->mycollection->mycollection;
    return $collection->find()->toArray();
});


Route::resource('faqs','FaqController');