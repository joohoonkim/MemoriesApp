<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Memories</title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <div class="app_banner">
            <h1>Memories</h1>
        </div>
        <div class="row">
            <div class="col-2 app_sidebar">
            </div>
            <div class="col-8 app_content">
                <h1>Lorem ipsum dolor sit amet.</h1>
                <div class="content_row">
                    <div class="content_column_3">
                        <img class="rounded img-fluid" src="{{asset('storage/images/stock1.jpg')}}" alt="stock1">
                        <img class="rounded img-fluid" src="{{asset('storage/images/stock5.jpg')}}" alt="stock2">
                    </div>
                    <div class="content_column_3">
                        <img class="rounded img-fluid" src="{{asset('storage/images/stock6.jpg')}}" alt="stock2">
                        <img class="rounded img-fluid" src="{{asset('storage/images/stock3.jpg')}}" alt="stock3">
                    </div>
                    <div class="content_column_3">
                        <img class="rounded img-fluid" src="{{asset('storage/images/stock2.jpg')}}" alt="stock3">
                        
                    </div>
                </div>
                <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Qui architecto ducimus laboriosam repellat. Molestias ipsam consequuntur ea amet accusamus. Officiis voluptas dolores exercitationem repudiandae perspiciatis pariatur neque non corrupti ipsum vero, quasi molestiae iusto temporibus! Commodi beatae ratione repellat itaque. Rem iusto harum, sequi tenetur quam consectetur vitae deleniti aperiam.
                </p>
            </div>
            <div class="col-2 app_sidebar">
            </div>
        </div>
    </body>
    <script>
        var posts = {!! json_encode($posts->toArray() ?? 'error retrieving post', JSON_HEX_TAG) !!};
        posts.forEach(function(p) {
            var images = p.images.split(',');
            console.log(images.length);
            console.log(p);
        });
    </script>
</html>
