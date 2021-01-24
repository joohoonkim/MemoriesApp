<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();           // Get all the posts, TODO::Limit amount using pagination
        return view('main')->with([     // Return the view, send all the posts to the view
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
        return view('create');
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

        return redirect('/main');
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
    }
}
