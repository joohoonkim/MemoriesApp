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
        <form id='post-form' enctype="multipart/form-data" method="POST">
            @csrf
            @method('POST')
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $post->title, ['id' => 'title', 'class' => 'form-control', 'placeholder' => 'Enter the title'])}}
            </div>
            @if($errors->has('title'))
                <p style="color:red;">{{ $errors->first('title') }}</p>
            @endif
            <div class="form-group">
                {{Form::label('description', 'Description')}}
                {{Form::textarea('description', $post->description, ['id' => 'description', 'class' => 'form-control', 'placeholder' => 'Enter a description'])}}
            </div>
            @if($errors->has('description'))
                <p style="color:red;">{{ $errors->first('description') }}</p>
            @endif
            <div class="form-group">
                <label class="event_date">Event Date</label><br>
                {{ Form::date('event_date', date('Y-m-d', strtotime($post->event_date)), ['id' => 'event_date']) }}  
            </div>
            <div class="form-group">
                <input id="upload-images" type="file" name="images[]" accept="image/*" onchange="loadImage(event)" style="display: none;" multiple>
                <label class="image-button" for="upload-images" style="cursor: pointer;">Upload Images</label>
            </div>
            <div class="create_content" id="edit_images">
            </div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </form>
    </div>
</main><!-- /.container -->
@endsection

@section('footer-scripts')
    <script src="{{ asset('js/edit_images.js') }}"></script>
    <script>
        // Global arrays
        var deleted_images = [];        // store original images that are deleted
        var imagesURL = "";             // path to image storage
        var original_posts = [];        // store all original images
        var new_posts = [];             // store new uploaded images    (for upload)
        var all_posts = [];             // store all images     (for display)
        var image_posts_final = [];     // store resized images (for upload)

        // Form Data constants
        const title = document.getElementById("title");
        const description = document.getElementById("description");
        const event_date = document.getElementById("event_date");
        const form = document.getElementById("post-form");

        // Original images displayed on webpage
        imagesURL = '{{asset('/storage/files/')}}';
        original_posts = {!! json_encode($post ?? 'error retrieving post', JSON_HEX_TAG) !!}.images.replace(/ /g,'').split(',');
        original_posts.forEach(function(element,index,array){
            array[index] = element;
        });
        all_posts = original_posts;
        window.displayEditImageGallery(all_posts, imagesURL);

        /* Remove image if "deleted" and display new organized image gallery */
        function removeImage(element){
            $('#edit_images').html("");
            if(original_posts.indexOf(element) > -1){   //It is an original post
                all_posts = all_posts.filter(item => item !== element);
                deleted_images.push(element);
            }else{
                // Handles element removable based on file name
                for(var i=0;i<all_posts.length;i++){
                    if(typeof all_posts[i] === 'object'){
                        if(all_posts[i].file.name == element){
                            all_posts.splice(i,1);
                        }
                    }
                }
                new_posts = new_posts.filter(item => item.file.name != element);
            }
            window.displayEditImageGallery(all_posts, imagesURL);
        }

        /* Convert canvas data url to blob */
        var dataURLToBlob = function(dataURL) {
            var BASE64_MARKER = ';base64,';
            if (dataURL.indexOf(BASE64_MARKER) == -1) {
                var parts = dataURL.split(',');
                var contentType = parts[0].split(':')[1];
                var raw = parts[1];

                return new Blob([raw], {type: contentType});
            }

            var parts = dataURL.split(BASE64_MARKER);
            var contentType = parts[0].split(':')[1];
            var raw = window.atob(parts[1]);
            var rawLength = raw.length;

            var uInt8Array = new Uint8Array(rawLength);

            for (var i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }

            return new Blob([uInt8Array], {type: contentType});
        }

        /* Resize the image file and append to image_posts_final */
        function resizeImage(file){
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function (e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function(ev){
                    var canvas = document.createElement('canvas');
                    var max_size = 800;
                    width = image.width;
                    height = image.height;

                    if(width > height){
                        if(width > max_size){
                            height *= max_size / width;
                            width = max_size;
                        }
                    }else{
                        if(height > max_size){
                            width *= max_size / height;
                            height = max_size;
                        }
                    }
                    canvas.width = width;
                    canvas.height = height;
                    canvas.getContext('2d').drawImage(image,0,0, width, height);
                    var dataUrl = canvas.toDataURL('image/jpeg');
                    var resizedImageBlob = dataURLToBlob(dataUrl);
                    var img_file = new File([resizedImageBlob], image_posts_final.length.toString()+"_image.jpg");
                    image_posts_final.push(img_file);
                    if(image_posts_final.length == new_posts.length){
                        sendForm();
                    }else{
                        let file = new_posts[image_posts_final.length].file;
                        resizeImage(file);
                    }
                }
            }
        }

        /* Display images on webpage after user uploads */
        var loadImage = function(event){
            if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
                alert('The File APIs are not fully supported in this browser.');
                return;
            }
            var input = document.getElementById('upload-images');
            if (!input) {
                alert("Um, couldn't find the upload-images element.");
            }
            else if (!input.files) {
                alert("This browser doesn't seem to support the `files` property of file inputs.");
            }
            else if (!input.files[0]) {
                alert("Please select a file before clicking 'Load'");               
            }
            else {
                for(i=0;i<input.files.length;i++){
                    var post = new Object();
                    post.id = all_posts.length;
                    post.file = input.files[i];
                    new_posts.push(post);
                    all_posts.push(post);
                }
                $('#edit_images').html("");
                window.displayEditImageGallery(all_posts, imagesURL);
            }
        }

        /* create FormData and send */
        function sendForm(){
            const formData = new FormData();
            formData.append('title',title.value);
            formData.append('description',description.value);
            formData.append('event_date',event_date.value);
            formData.append('deleted_images',deleted_images);

            for(j=0;j<image_posts_final.length;j++){
                let file = image_posts_final[j];
                formData.append('images[]',file);
            }

            $.ajax({
                url: window.location.href,
                data: formData,
                redirect: 'follow',
                processData: false,
                contentType: false,
                credentials: "same-origin",
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'POST',
                success: function(response){
                    window.location.pathname = "/";
                },
                error: function(response){
                    console.log(response);
                }
            });
        }

        /* Listener for submit */
        form.addEventListener('submit', (e) =>{
            e.preventDefault();
            if(new_posts.length > 0){
                let file = new_posts[0].file;
                resizeImage(file);
            }else{
                sendForm();
            }
        });

        /* Confirmation before deleting post */
        $(function() {
            $('#delete-form').click(function() {
                return window.confirm("Are you sure?");
            });
        });
    </script>
@endsection
