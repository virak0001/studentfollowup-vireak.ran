<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Studentt
Route::resource('student', 'StudentController')->middleware('auth');  

Route::get('editStudent/{id}','StudentController@edit')->name('editStudent.edit')->middleware('auth');

Route::put('addToFollowUp/{id}','StudentController@addToFollowUp')->name('addToFollowUp')->middleware('auth');

Route::put('outOfFollowUP/{id}','StudentController@outOfFollowUP')->name('outOfFollowUP')->middleware('auth');


// comment
Route::put('comment.store/{id}','CommentController@store')->name('comment.store');

Route::put('comment.update/{id}','CommentController@update')->name('comment.update');

Route::delete('comment.destroy/{id}','CommentController@destroy')->name('comment.destroy');
