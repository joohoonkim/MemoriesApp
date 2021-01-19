<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Memories</title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <div class="row">
            <div class="col-12 app_banner">
                <h1>Memories</h1>
                <div class="btn">
                    <a href="/main/create">Create</a>
                </div>
            </div>
            <div class="col-2 app_sidebar">
            </div>
            <div class="col-8 app_content" id="post">
            </div>
            <div class="col-2 app_sidebar">
            </div>
        </div>
    </body>
    <script>
        var imagesURL = '{{asset('/storage/images/')}}';
        console.log(imagesURL);
        var posts = {!! json_encode($posts->toArray() ?? 'error retrieving post', JSON_HEX_TAG) !!};
    </script>
    <script src="/js/app.js"></script>
</html>
