<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', function () {
    // $posts  = Post::all();
    // $posts  = Post::where('user_id', auth()->id())->get();
    $posts = [];
    if(auth()->check()){
        $posts = auth()->user()->usersCoolPosts()->latest()->get();
        $userInfo = auth()->user();
    };

    return view('home', ['posts'=> $posts, 'user' => $userInfo]);
});

Route::post('/register', [UserController::class, 'register']);

Route::post('/logout', [UserController::class, 'logout']); //'logout', name a method controller

Route::post('/login', [UserController::class, 'login']); 


// Blog post related routes
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
Route::put('/edit-post/{post}', [PostController::class], 'actuallyUpdatePost');
Route::delete('/delete-post/{post}', [PostController::class], 'deletePost');