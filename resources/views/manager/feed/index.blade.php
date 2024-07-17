@extends('layouts.manager')

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/moment/moment.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/chat/chat.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/manager/feed/news.js') }}"></script>
    <script>
        $(function() {
            var onResize = function() {
                //var docHeight = window.innerHeight;
                var docHeight = ($(window).outerHeight());
                var docHeight_1 = (docHeight - 251);
                $('body').css({"height": docHeight});
                $('.chat-wrapper').css({"min-height":docHeight_1, "height": docHeight_1});
            };

            $(window).on('resize', onResize);
            onResize();
        });

        $(document).ready(function(){
            let tparams = (new URL(document.location)).searchParams;
            let tfrom = tparams.get("from");
            if(tfrom == 'news_details') {
                $('li.nav-item a#news-tab').trigger('click');
            }
        });
    </script>
@endpush

<style type="text/css">
    .chat-wrapper {
        display: flex;
        flex-direction: column;
        width: 100%;
        /*height: calc(100vh - 151px);*/
        -webkit-overflow-scrolling: touch;
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        -ms-flex-negative: 1;
        flex-shrink: 1;
        overflow: auto;
    }
    .chat-body {
      -webkit-overflow-scrolling: touch;
      -webkit-box-flex: 1;
      -ms-flex-positive: 1;
      flex-grow: 1;
      -ms-flex-negative: 1;
      flex-shrink: 1;
      overflow: auto;
      padding: 10px;
    }
    #loader {
        display:none;
    }

    .chat {
        display: flex;
    }

    .chat.message-reciever {
        justify-content: flex-start;
    }

    .chat.message-reciever .messege-container .messege {
        background-color: #82ccdd;
    }

    .chat.message-system .messege-container .messege {
        background-color: #eee;
        color: black;
    }

    .chat.message-sender {
        justify-content: flex-end;
    }

    .chat.message-sender .messege-container .messege {
        background-color: #78e08f;
    }

    .chat.message-sender .messege-container .messege .profile-name,
    .chat.message-reciever .messege-container .messege .profile-name {
        font-weight: bold;
    }

    .chat.message-sender .messege-container .messege .profile-name,
    .chat.message-sender .messege-container .messege .profile-msg,
    .chat.message-reciever .messege-container .messege .profile-name,
    .chat.message-reciever .messege-container .messege .profile-msg {
        font-size: 12px;
    }

    .chat .messege-container {
        /*-webkit-box-flex: 0;
        -ms-flex: 0 0 80%;
        flex: 0 0 80%;*/
        max-width: 80%;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .chat .messege-container .messege {
        padding: 10px;
        position: relative;
        border-radius: 4px;
    }

    .chat .messege-container .messege-info {
        margin-top: 5px;
        font-size: 10px;
    }

    .chat-date {
        padding: 2px 0;
        text-align: center;
        font-size: 80%;
    }
    .js-chat-create-form {
        position: sticky;
        padding: 10px 0 0;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
    }

    .js-delete-message {
        cursor: pointer;
    }

    .chat .messege-container {
        position: relative;
    }

    .chat .messege-container .messege-info,
    .chat .messege-container .js-delete-message {
        position:absolute;
    }

    .chat.message-reciever .js-delete-message {
        right: -25px;
    }

    .chat.message-sender .js-delete-message {
        left: -25px;
    }

    .chat.message-reciever .js-delete-message,
    .chat.message-sender .js-delete-message {
        top: 2px;
    }

</style>

@include('partials.manager.leagues')

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li> <a href="{{ route('manage.division.info', ['division' => $division]) }}"><span><i class="fas fa-chevron-left mr-2"></i></span>Back</a> </li>
                <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                <li> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation"> <span class="fl fl-bar"></span> </button> </li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12">
        <div class="container-wrapper">
            <div class="container-body">
                <div class="text-white js-data-filter-tabs js-data-chat-feed-area">
                    <ul class="nav nav-info nav-justified theme-tabs theme-tabs-secondary my-0" id="info-tab" role="tablist">
                        @can('isChairmanOrManager', [$division, $team])
                            <li class="nav-item">
                                <a class="nav-link active" id="chat-tab" data-toggle="pill" href="#chat" role="tab" aria-controls="chat" aria-selected="true" data-load="0">Chat <span class="badge badge-pill badge-danger js-chat-span-tab"></span></a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link" id="news-tab" data-toggle="pill" href="#news" role="tab" aria-controls="news" aria-selected="false" data-load="0">News <span class="badge badge-pill badge-danger js-feed-span-tab"></span></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="info-tabContent">
                        @can('isChairmanOrManager', [$division, $team])
                        <div class="tab-pane fade show active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                            <div class="mt-3">
			                    <div class="row">
			                        <div class="col-12 text-white">
			                            <div class="chat-wrapper">
			                                <div id="loader" class="text-center">
			                                    <i class="fas fa-circle-notch fa-spin"></i>
			                                </div>
			                                <div class="chat-body" id="chatWindow">
			                                    @include('manager.feed.partials.message')
			                                </div>
			                                @if(!$messages->count())
			                                    <div class="text-center no-message">No one has said anything yet</div>
			                                @endif
			                            </div>
			                            <form method="POST" class="js-chat-create-form mb-0">
			                                @csrf
			                                <div class="input-group">
			                                    <input class="form-control form-control" placeholder="Type your message here." aria-label="Message area" aria-describedby="btnMessage" id="message" name="message" />
			                                    <div class="input-group-append">
			                                        <button type="submit" class="btn btn-primary btn" id="btnMessage"><i class="fas fa-paper-plane mr-2"></i>Send</button>
			                                    </div>
			                                </div>
			                            </form>
			                        </div>
			                    </div>
				            </div>
				        </div>
                        @endcan
                        <div class="tab-pane fade" id="news" role="tabpanel" aria-labelledby="news-tab">
                            <div class="mt-3">
                                <div class="blog-section" id="posts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
