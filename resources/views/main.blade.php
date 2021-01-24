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
            <h1>
                Memories
            </h1>
            <div class="create-button">
                <a href="/main/create">Create</a>
            </div>
        </div>
        <div class="app_container">
            <div class="app_sidebar">
            </div>
            <div class="app_content shadow-sm" id="post">
            </div>
            <div class="app_sidebar">
            </div>
        </div>
    </body>
    <script>
        var imagesURL = '{{asset('/storage/files/')}}';
        console.log(imagesURL);
        var posts = {!! json_encode($posts->toArray() ?? 'error retrieving post', JSON_HEX_TAG) !!};
    </script>
    <script src="/js/app.js"></script>
</html>
