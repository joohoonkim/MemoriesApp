@extends('layouts.app')

@section('content')
<main class="create-page" role="content">
    <div class="rounded content-main shadow-sm" style="margin-top:2rem; margin-bottom:2rem; padding:4rem;">
        <h1>Add a Memory</h1>
    </div>
    <div class="rounded content-main shadow-sm" style="margin-top:2rem; margin-bottom:2rem; padding:4rem;">
        <form action='/create' id='post-form' enctype="multipart/form-data" method="POST">
            @csrf
            <div class="form-group">
                <label class="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter the title">
            </div>
            @if($errors->has('title'))
                <p style="color:red;">{{ $errors->first('title') }}</p>
            @endif
            <div class="form-group">
                <label class="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter a description"></textarea>
            </div>
            @if($errors->has('description'))
                <p style="color:red;">{{ $errors->first('description') }}</p>
            @endif
            <div class="form-group">
                <label class="event_date">Event Date</label><br>
                {{ Form::date('event_date', date('Y-m-d'), ['id' => 'event_date']) }}  
            </div>
            <div class="form-group">
                <input id="upload-images" type="file" name="images[]" accept="image/*" onchange="loadImage(event)" style="display: none;" multiple>
                <label class="image-button" for="upload-images" style="cursor: pointer;">Upload Images</label>
            </div>
            <div class="create_content" id="edit_images">
            </div>
            <br>
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main><!-- /.container -->
@endsection


@section('footer-scripts')
    <script src="{{ asset('js/edit_images.js') }}"></script>
    <script>
        // Global arrays
        var all_posts = [];             // store user selected images
        var image_posts_final = [];     // store resized images

        // Form Data constants
        const title = document.getElementById("title");
        const description = document.getElementById("description");
        const event_date = document.getElementById("event_date");
        const form = document.getElementById("post-form");

        /* Remove image if "deleted" and display new organized image gallery */
        function removeImage(element){
            $('#edit_images').html("");
            all_posts = all_posts.filter(item => item.file.name != element);
            window.displayEditImageGallery(all_posts);
        };

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
                    if(image_posts_final.length == all_posts.length){
                        sendForm();
                    }else{
                        let file = all_posts[image_posts_final.length].file;
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
                    all_posts.push(post);
                }
                $('#edit_images').html("");
                window.displayEditImageGallery(all_posts);
            }
        }

        /* create FormData and send */
        function sendForm(){
            const formData = new FormData();
            formData.append('title',title.value);
            formData.append('description',description.value);
            formData.append('event_date',event_date.value);

            for(j=0;j<image_posts_final.length;j++){
                let file = image_posts_final[j];
                formData.append('images[]',file);
            }

            $.ajax({
                url: form.getAttribute('action'),
                data: formData,
                redirect: 'follow',
                processData: false,
                contentType: false,
                credentials: "same-origin",
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: form.getAttribute('method'),
                success: function(response){
                    window.location.pathname = "/";
                }
            });
        }

        /* Listener for submit */
        form.addEventListener('submit', (e) =>{
            e.preventDefault();
            if(all_posts.length > 0){
                let file = all_posts[0].file;
                resizeImage(file);
            }else{
                sendForm();
            }
        });
    </script>
@endsection
