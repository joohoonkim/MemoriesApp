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
            var post_editable = true;
        </script>
    @else
        <script>
            var post_editable = false;
        </script>
    @endif
    
    <script src="{{ asset('js/post_gallery.js') }}"></script>
    <script>
        var imagesURL = '{{asset('/storage/files/')}}';
        var posts = {!! json_encode($posts->toArray() ?? 'error retrieving post', JSON_HEX_TAG) !!};
        window.mainDisplayPosts(posts,post_editable);
    </script>

    <script type="text/javascript">

        // page globals
        var page = 1;               //keep track of pagination
        var page_end = false;       //status if there are no more pages left

        /* user scroll near bottom of the page event, load more data */
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height()-100) {
                page++;
                loadMoreData(page);
            }
        });
    
        /* load more data */
        function loadMoreData(page){
            if(page_end == false){
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
                            if (!document.getElementById("app_footer")) {
                                appendFooter();
                            }
                            page_end = true;
                            return;
                        }
                        mainDisplayPosts(data.posts,post_editable);
                        $('.ajax-load').hide();
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError)
                    {
                        alert('server not responding...');
                    });
            }
        }

        /* append footer */
        function appendFooter(){
            $('.ajax-load').hide();
            let footer_element = document.getElementById("app"); //element to put gallery
            let footer_string = "<div class='app_footer' id='app_footer'></div>";
            footer_element.insertAdjacentHTML("beforeend",footer_string);
        }
    </script>
@endsection