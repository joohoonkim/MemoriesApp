@extends('layouts.app')

@section('content')
    <div class="app_container">
        <div class="app_sidebar">
        </div>
        <div class="app_content shadow-sm" id="post">
        </div>
        <div class="app_sidebar">
        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        var imagesURL = '{{asset('/storage/files/')}}';
        var posts = {!! json_encode($posts->toArray() ?? 'error retrieving post', JSON_HEX_TAG) !!};
    </script>
@endsection