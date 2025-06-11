<?php

use App\Http\Controllers\Chatgpttest1Controller;
use Illuminate\Support\Facades\Route;


Route::get('/chatgpt_test1',[Chatgpttest1Controller::class,'index']);
Route::get('/completion',[Chatgpttest1Controller::class,'completionView']);
Route::post('/completion',[Chatgpttest1Controller::class,'completionExec']);
Route::get('/threadq',[Chatgpttest1Controller::class,'threadQStart']);
Route::post('/threadq',[Chatgpttest1Controller::class,'threadQexec']);


Route::get('/', function () {


    return view('welcome');



});


