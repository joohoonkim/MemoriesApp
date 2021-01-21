<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Memories</title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <main role="content" class="container-fluid">
            <div class="row">
                <!-- Content Main -->
                <div class="col-md-12">
                    <div class="rounded content-main shadow-sm" style="margin-top:2rem; margin-bottom:2rem; padding:4rem;">
                        <h1>Add a Memory</h1>
                    </div>
                    <div class="rounded content-main shadow-sm" style="margin-top:2rem; margin-bottom:2rem; padding:4rem;">
                        {!! Form::open(['action' => 'App\Http\Controllers\PostController@store', 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
                            <div class="form-group">
                                {{Form::label('title', 'Title')}}
                                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Enter the title'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('body', 'Description')}}
                                {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Enter a description'])}}
                            </div>
                            <div class="form-group">
                                {{ Form::date('event_date', date('Y-m-d', strtotime(date("Y-m-d")))) }}  
                            </div>
                            <div class="form-group">
                                <input type="file" name="images[]" accept="image/*" multiple>
                            </div>
                            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                        {!! Form::close() !!}
                    </div>
                </div><!-- /.content-main -->
            </div><!-- /.content-page -->
        </main><!-- /.container -->
    </body>
</html>
