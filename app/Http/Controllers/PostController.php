<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.x
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::search()->with(['user', 'category', 'photos', 'tags'])->latest("id")->paginate(5); // search() is written by local query scope
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $request->validate([
            "title" => "required|min:3|unique:posts,title",
            "category" => "required|integer|exists:categories,id",
            "description" => "required|min:5",
            "photo" => "nullable",
            "photo.*" => "file|mimetypes:image/jpeg,image/png",
            "tags" => "required",
            "tags.*" => "integer|exists:tags,id",
        ]);

        DB::transaction(function () use ($request) {

            $post = new Post();
            $post->title = $request->title;
            $post->slug = $request->title; // with mutator
            $post->description = $request->description;
            $post->excerpt = Str::words($request->description, 20);
            $post->category_id = $request->category;
            $post->user_id = Auth::id();
            $post->is_publish = true;
            $post->save();

            // save tags in pivot table
            $post->tags()->attach($request->tags);

            // auto create folder
            if(!Storage::exists("public/thumbnail")){
                Storage::makeDirectory("public/thumbnail");
            }

            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {

                    // store file
                    $newName = uniqid()."_photo.".$photo->extension();
                    $photo->storeAs("public/photo/", $newName);

                    // making thumbnail
                    $img = Image::make($photo);
                    $img->fit(200, 200);
                    $img->save("storage/thumbnail/".$newName);

                    // save in db
                    $photo = new Photo();
                    $photo->name = $newName;
                    $photo->post_id = $post->id;
                    $photo->user_id = Auth::id();
                    $photo->save();
                }
            }

        });

        return redirect()->back()->with('status', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        Gate::authorize("update-post", $post);
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePostRequest $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validate([
            "title" => "required|min:3|unique:posts,title,$post->id",
            "category" => "required|integer|exists:categories,id",
            "description" => "required|min:5",
//            "photo" => "required",
        ]);

//        return $request;

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description,20);
        $post->category_id = $request->category;
        $post->update();

        // delete all record from pivot table
        $post->tags()->delete();

        // save db record in pivot table
        $post->tags()->attach($request->tags);

        return redirect()->route('post.index')->with('status', 'Post Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        foreach ($post->photos as $photo) {
            // file delete
            Storage::delete('public/photo/'.$photo->name);
            Storage::delete('public/thumbnail/'.$photo->name);

        }

        // delete db record from hasMany in photo table
        $post->photos()->delete();

        // delete db record from pivot table
        $post->tags()->delete();

        // post delete
        $post->delete();
        return redirect()->back()->with("status", "Post Deleted");
    }
}
