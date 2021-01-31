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
    <div class="ajax-load text-center" style="display:none">
        <p>Loading More post</p>
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
    <script src="{{ asset('js/post_gallery.js') }}" defer></script>
    <script>
        var imagesURL = '{{asset('/storage/files/')}}';
        var posts = {!! json_encode($posts->toArray() ?? 'error retrieving post', JSON_HEX_TAG) !!};
    </script>
    <script type="text/javascript">
        var page = 1;
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                loadMoreData(page);
            }
        });
    
        function loadMoreData(page){
            $.ajax(
                {
                    url: '/?page=' + page,
                    type: "get",
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
                .done(function(data)
                {
                    if(data.posts.data.length == 0){
                        $('.ajax-load').html("<div class='app_footer'></div>");
                        return;
                    }
                    mainDisplayPosts(data.posts);
                    $('.ajax-load').hide();
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                      alert('server not responding...');
                });
        }
    </script>
@endsection