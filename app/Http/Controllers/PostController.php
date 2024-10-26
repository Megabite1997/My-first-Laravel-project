<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function deletePost(Post $post){
        if(auth()->user()->id === $post['user_id']){
            $post->delete();
        }
        return redirect('/register');
    }

    public function actuallyUpdatePost(Post $post, Request $request){
        //Post is things we want to update.
        //Request is giving us the form request data from user.
        if(auth()->user()->id !== $post['user_id']){
            return redirect('/register');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return redirect('/register');

    }

    public function showEditScreen(Post $post){ 
        //If the name here matches the dynamic url, Laravel is going perform database lookup.
        if(auth()->user()->id !== $post['user_id']){
            return redirect('/register');
        }

        return view('edit-post',['post'=> $post]);
    }

    public function createPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        Post::create($incomingFields);
        return redirect('/register');
    }
}