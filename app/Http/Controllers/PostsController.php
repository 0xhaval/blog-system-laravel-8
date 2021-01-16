<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        // upload image to storage
        //$imageName = time().'.'.$post->image->extension();
     
        //$post->image->move(public_path('images'), $imageName);
        $img = $request->image->store('posts');
        // create post
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $img,
            'published_at' => $request->published_at,
            'category_id' => $request->category // use category instead category_id beacuse the name in form is category 
        ]);

        if($request->tags){
            // attach method is belong to Many relationship 
            $post->tags()->attach($request->tags);
        }
        
        // redirect user 
        return redirect()->route('posts.index')->with('success', 'Post created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)
                                ->with('categories', Category::all())
                                ->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request,Post $post)
    {
        // for more secure use only to prevent hacker for request another field 
        $data = $request->only(['title', 'description', 'content', 'published_at', 'category']);

        // check if new image 
        if($request->hasFile('image')){

        // upload it    
        $img = $request->image->store('posts');

        // delete old one 
        $post->deleteImage();

        $data['image'] = $img;
        }
        

        if($request->tags){
            $post->tags()->sync($request->tags);
        }
        // upload attributes
        $post->update($data);

        // redirect user 
        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // use $id instead Model binding post beacuse this post is trashed 
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        // here I use soft delete to delete post, 
        // after delete post, the model will inset current time to deleted_at field 
        if($post->trashed()){
            $post->deleteImage();  // delete image when delete post
            $post->forceDelete();
        }else{
            $post->delete();
        }
        return redirect()->back()->with('success', 'Post restore successfully');

    }

    /**
     * Display a list of all trashed post.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->with('posts', $trashed);
    }

    /**
     * 
     * Restore trashed post 
     * 
     * @return int $id 
     * 
     */
    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        $post->restore();
        return redirect()->back()->with('success', 'Post restore successfully');
    }
}

