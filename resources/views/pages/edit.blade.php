@extends('layouts.app')

@section('content')
<main class="create-page" role="content">
    <div class="rounded content-main shadow-sm" style="margin-top:2rem; margin-bottom:2rem; padding:4rem;">
        <h1>Edit a Memory</h1>
    </div>
    <div class="rounded content-main shadow-sm" style="margin-top:2rem; margin-bottom:2rem; padding:4rem;">
        {!! Form::open(['action' => ['App\Http\Controllers\PostController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right', 'id' => 'delete-form']) !!}
            @csrf
            @method('DELETE')
            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
        {!! Form::close() !!}
        <br>
        {!! Form::open(['action' => ['App\Http\Controllers\PostController@update', $post->id], 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
            @csrf
            @method('PUT')
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Enter the title'])}}
            </div>
            @if($errors->has('title'))
                <p style="color:red;">{{ $errors->first('title') }}</p>
            @endif
            <div class="form-group">
                {{Form::label('description', 'Description')}}
                {{Form::textarea('description', $post->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Enter a description'])}}
            </div>
            @if($errors->has('description'))
                <p style="color:red;">{{ $errors->first('description') }}</p>
            @endif
            <div class="form-group">
                {{ Form::date('event_date', date('Y-m-d', strtotime($post->event_date))) }}  
            </div>
            <div class="form-group">
                <input type="file" name="images[]" accept="image/*" onchange="loadImage(event)" multiple>
            </div>
            <div class="app_content" id="edit_images">
            </div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
</main><!-- /.container -->
@endsection

@section('footer-scripts')
    <script src="{{ asset('js/edit_images.js') }}"></script>
    <script>
        // remove image if "deleted" and display new organized image gallery.
        function removeImage(element){
            $('#edit_images').html("");
            var indx = all_posts.indexOf(element);
            all_posts = all_posts.filter(item => item !== element)
            window.displayEditImageGallery(all_posts,imagesURL);
        };
    </script>
    <script>
        // Initial images displayed on webpage
        var imagesURL = '{{asset('/storage/files/')}}';
        var original_posts = {!! json_encode($post ?? 'error retrieving post', JSON_HEX_TAG) !!}.images.replace(/ /g,'').split(',');
        original_posts.forEach(function(element,index,array){
            array[index] = imagesURL + "/" + element;
        });
        window.displayEditImageGallery(original_posts,imagesURL);
        var all_posts = original_posts;

        // Load images on webpage after user uploads
        var loadImage = function(event){
            Array.from(event.target.files).forEach(function(element, index, array){
                if(all_posts == ""){
                    all_posts.push(URL.createObjectURL(element));
                }
                all_posts.push(URL.createObjectURL(element));
            });
            $('#edit_images').html("");
            window.displayEditImageGallery(all_posts,imagesURL);
        }
    </script>
    <script>
        $(function() {
            $('#delete-form').click(function() {
                return window.confirm("Are you sure?");
            });
        });
    </script>
@endsection
