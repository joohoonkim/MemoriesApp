<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Memories</title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <div class="rounded content-main shadow-sm" style="margin-top:2rem; margin-bottom:2rem; padding:4rem;">
        {!! Form::open(['action' => 'App\Http\Controllers\PagesController@authenticate', 'method' => 'POST']) !!}
            <div class="form-group">
                {{Form::text('username', "", ['placeholder'=>'Username','maxlength'=>30])}}
            </div>
            <div class="form-group">
                {{Form::password('password', ['placeholder'=>'Password','maxlength'=>30])}}
            </div>
            {{Form::submit('Submit')}}
        {!! Form::close() !!}
        </div>
    </body>
</html>
