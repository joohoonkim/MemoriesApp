<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();           // Get all the posts, TODO::Limit amount using pagination
        return view('pages.main')->with([     // Return the view, send all the posts to the view
            'posts'=>$posts
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = new Post;
        
        $post->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title'));
        $post->title = $request->input('title');
        $post->event_date = $request->input('event_date');
        $post->description = $request->input('body');
        $images_string = "";

        if($request->hasfile('images'))
        {
            $i = 0;
            foreach($request->file('images') as $key => $file)
            {
                $path = $file->store('public/files');
                echo $file.'<br>';
                echo $path.'<br>';
                $str_arr = preg_split ("~/~", $path);  
                if(++$i === count($request->file('images'))){
                    $images_string .= end($str_arr);
                }else{
                    $images_string .= end($str_arr).",";
                }
            }
        }
        $post->images = $images_string;
        $post->gallery_type = "true";
        $post->save();

        return redirect('/');
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
    public function edit($id)
    {
        //
        $post = Post::find($id);
        return view('pages.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = Post::find($id);
        
        $post->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title'));
        $post->title = $request->input('title');
        $post->event_date = $request->input('event_date');
        $post->description = $request->input('body');
        $images_string = $post->images;

        if($images_string !== ""){
            $images_string .= ",";
        }

        if($request->hasfile('images'))
        {
            $i = 0;
            foreach($request->file('images') as $key => $file)
            {
                $path = $file->store('public/files');
                $str_arr = preg_split ("~/~", $path);  
                if(++$i === count($request->file('images'))){
                    $images_string .= end($str_arr);
                }else{
                    $images_string .= end($str_arr).",";
                }
            }
        }
        $post->images = $images_string;
        $post->gallery_type = "true";
        $post->save();

        return redirect('/')->with('success', 'Memory Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);

        $images_array = explode(',', $post->images);
        foreach($images_array as $img){
            Storage::delete("public/files/".$img);
        }

        $post->delete();
        return redirect('/')->with('success', 'Memory Deleted');
    }
}
