<?php

use App\Http\Controllers\Chatgpttest1Controller;
use App\Http\Controllers\ReacttestController;
use Illuminate\Support\Facades\Route;


Route::get('/chatgpt_test1',[Chatgpttest1Controller::class,'index']);
Route::get('/completion',[Chatgpttest1Controller::class,'completionView']);
Route::post('/completion',[Chatgpttest1Controller::class,'completionExec']);
Route::get('/threadq',[Chatgpttest1Controller::class,'threadQStart']);
Route::post('/threadq',[Chatgpttest1Controller::class,'threadQexec']);

Route::get('/react_test1',function(){ return view('react_test1/index'); });
Route::post('/react_q',[ReacttestController::class,'threadQexec']);


Route::get('/', function () {


    return view('welcome');



});


