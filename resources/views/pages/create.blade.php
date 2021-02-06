@extends('layouts.app')

@section('content')
<main class="create-page" role="content">
    <div class="rounded content-main shadow-sm" style="margin-top:2rem; margin-bottom:2rem; padding:4rem;">
        <h1>Add a Memory</h1>
    </div>
    <div class="rounded content-main shadow-sm" style="margin-top:2rem; margin-bottom:2rem; padding:4rem;">
        {!! Form::open(['action' => 'App\Http\Controllers\PostController@store', 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
            @csrf
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Enter the title'])}}
            </div>
            @if($errors->has('title'))
                <p style="color:red;">{{ $errors->first('title') }}</p>
            @endif
            <div class="form-group">
                {{Form::label('description', 'Description')}}
                {{Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Enter a description'])}}
            </div>
            @if($errors->has('description'))
                <p style="color:red;">{{ $errors->first('description') }}</p>
            @endif
            <div class="form-group">
                {{ Form::date('event_date', date('Y-m-d', strtotime(date("Y-m-d")))) }}  
            </div>
            <div class="form-group">
                <input id="upload-images" type="file" name="images[]" accept="image/*" onchange="loadImage(event)" style="display: none;" multiple>
                <label class="image-button" for="upload-images" style="cursor: pointer;">Upload Images</label>
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
            window.displayEditImageGallery(all_posts);
        };
    </script>
    <script>
        var all_posts = [];

        // Load images on webpage after user uploads
        var loadImage = function(event){
            Array.from(event.target.files).forEach(function(element, index, array){
                if(all_posts == ""){
                    all_posts.push(URL.createObjectURL(element));
                }
                all_posts.push(URL.createObjectURL(element));
            });
            $('#edit_images').html("");
            window.displayEditImageGallery(all_posts);
        }
    </script>
@endsection
