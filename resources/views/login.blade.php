<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Memories</title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <div class="rounded login_box shadow-sm">
        {!! Form::open(['action' => 'App\Http\Controllers\PagesController@authenticate', 'method' => 'POST']) !!}
            <div class="form-group">
                {{Form::text('passphrase', "", ['placeholder'=>'What is the pass phrase?','maxlength'=>30])}}
            </div>
            {{Form::submit('Enter')}}
        {!! Form::close() !!}
        </div>
    </body>
</html>
