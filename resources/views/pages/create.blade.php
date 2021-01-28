@extends('layouts.app')

@section('content')
<main class="create-page" role="content">
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
</main><!-- /.container -->
@endsection