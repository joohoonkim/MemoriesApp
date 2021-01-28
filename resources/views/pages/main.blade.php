@extends('layouts.app')

@section('content')
    <div class="app_container">
        <div class="app_sidebar">
        </div>
        <div class="app_content shadow-sm" id="post">
            @if(count($posts) < 1)
                <p>No memories yet.</p>
            @endif
        </div>
        <div class="app_sidebar">
        </div>
    </div>
@endsection

@section('footer-scripts')
    @if(Auth::user()->email == "admin@memories.app")
        <script>
            var editable_g = true;
        </script>
    @else
        <script>
            var editable_g = false;
        </script>
    @endif
    <script>
        var imagesURL = '{{asset('/storage/files/')}}';
        var posts = {!! json_encode($posts->toArray() ?? 'error retrieving post', JSON_HEX_TAG) !!};
    </script>
    {{-- <script>
        window.onscroll = function() {myFunction()};

        var navbar = document.getElementById("navbar_container");
        var sticky = document.getElementsByClassName("app_container")[0].offsetTop;

        function myFunction() {
            console.log(sticky);
            console.log(window.pageYOffset);
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("app_banner_sticky");
                navbar.classList.remove("app_banner")
            } else {
                navbar.classList.remove("app_banner_sticky");
                navbar.classList.add("app_banner");
            }
        }
    </script> --}}
@endsection