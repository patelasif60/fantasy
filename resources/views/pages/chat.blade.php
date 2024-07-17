@extends('layouts.auth.redesign')

@push('header-content')
@include('partials.auth.header')
@endpush

@push('plugin-styles')
@endpush

@push('footer-content')
@include('partials.auth.footer')
@endpush

@push('plugin-scripts')
@endpush

@push('page-scripts')
<script>
    function ChatHeight(){
        let HeaderHeight = $('.header').height();
        let FooterHeight = $('.footer').outerHeight();
        let windowHeight = $(window).innerHeight();
        let viewPortHeight = document.documentElement.clientHeight;
        let containerHeight = viewPortHeight - HeaderHeight;
        let containerHeightFoot = viewPortHeight - (HeaderHeight + FooterHeight);
        let ElementHeight = windowHeight;
        $(function(){
            // $('body').css({ 'height': ElementHeight, 'min-height': 'unset', 'overflow': 'hidden' });
            // $('.body').css({ 'height': ElementHeight });
            // $('.container-wrapper').css({ 'height': containerHeightFoot });
            $('.chat').height(containerHeightFoot);
        });
    }
    ChatHeight();
    $(window).bind("load", function() {
        ChatHeight();
    });
    $(window).on("orientationchange, resize", function(event) {
        ChatHeight();
    });
    (function() {
        var measurer = $('<span>', {
            style: "display:inline-block;word-break:break-word;visibility:hidden;white-space:pre-wrap;"
        })
        .appendTo('body');

        function initMeasurerFor(textarea) {
            if (!textarea[0].originalOverflowY) {
                textarea[0].originalOverflowY = textarea.css("overflow-y");
            }
            var maxWidth = textarea.css("max-width");
            measurer.text(textarea.text())
            .css("max-width", maxWidth == "none" ? textarea.width() + "px" : maxWidth)
            .css('font', textarea.css('font'))
            .css('overflow-y', textarea.css('overflow-y'))
            .css("max-height", textarea.css("max-height"))
            .css("min-height", textarea.css("min-height"))
            .css("min-width", textarea.css("min-width"))
            .css("padding", textarea.css("padding"))
            .css("border", textarea.css("border"))
            .css("box-sizing", textarea.css("box-sizing"))
        }

        function updateTextAreaSize(textarea) {
            textarea.height(measurer.height());
            var w = measurer.width();
            if (textarea[0].originalOverflowY == "auto") {
                var mw = textarea.css("max-width");
                if (mw != "none") {
                    if (w == parseInt(mw)) {
                        textarea.css("overflow-y", "auto");
                    } else {
                        textarea.css("overflow-y", "hidden");
                    }
                }
            }
            textarea.width(w + 2);
        }

        $('textarea.autofit').on({
            input: function() {
                var text = $(this).val();
                if ($(this).attr("preventEnter") == undefined) {
                    text = text.replace(/[\n]/g, "<br>&#8203;");
                }
                measurer.html(text);
                updateTextAreaSize($(this));
            },

            focus: function() {
                initMeasurerFor($(this));
            },

            keypress: function(e) {
                if (e.which == 13 && $(this).attr("preventEnter") != undefined) {
                    e.preventDefault();
                }
            }
        });
    })();
    $('#chat').on('show.bs.modal', function (e) {
       $('body').addClass('chat-appears');
       $('.navigation-link[data-target="#chat"]').addClass('active');
       $('.footer-navigation .navigation-tab .chat-popup').addClass('d-lg-inline-block');
    });
    $('#chat').on('hidden.bs.modal', function (e) {
       $('body').removeClass('chat-appears');
       $('.navigation-link[data-target="#chat"]').removeClass('active');
       $('.footer-navigation .navigation-tab .chat-popup').removeClass('d-lg-inline-block');
    });
</script>
@endpush

@section('content')

{{-- <div class="row align-items-center justify-content-center">
    <div class="col-12">
        <div class="container-wrapper">
            <div class="container-body">
                <div class="row justify-content-center h-100">
                    <div class="col-md-12">
                        <div class="chat">
                            <div class="chat-bg">
                                <div class="chat-img"></div>
                                <div class="chat-overlay"></div>
                            </div>
                            <div class="chat-header">
                            </div>
                            <div class="chat-body">
                            </div>
                            <div class="chat-footer">
                                <div class="input-group">
                                    <div class="input-group-append position-relative">
                                        <span class="input-group-text attach_btn">
                                            <i class="fas fa-paperclip"></i>
                                        </span>
                                        <input type="file" id="chat-attachment">
                                    </div>
                                    <textarea name="" class="form-control autofit" placeholder="Type your message..."></textarea>
                                    <div class="input-group-append">
                                        <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="chat">
    <div class="chat-bg">
        <div class="chat-img">
            <img class="lazyload" src="{{ asset('assets/frontend/img/chat/chat-bg-thumb.png')}}" data-src="{{ asset('assets/frontend/img/chat/chat-bg.png')}}" alt="">
            <div class="chat-overlay"></div>
        </div>
    </div>
    <div class="chat-header">

    </div>
    <div class="chat-body">
        <div class="chat-wrapper">
            <div class="chat-area">
                <div class="chat-container">
                    <div class="custom-alert alert-tertiary">
                        <div class="alert-icon">
                            <img src="{{ asset('assets/frontend/img/cta/icon-whistle.svg')}}" alt="alert-img">
                        </div>
                        <div class="alert-text">
                            No one has said anything yet. How about starting the conservation.
                        </div>
                    </div>
                </div>
                <div class="chat-container is-sender">
                    <div class="chat-body">
                        <div class="chat-header">
                            <span class="name">Ed Will</span>
                        </div>
                        <div class="chat-preview"></div>
                        <div class="chat-content">
                            Its okay. Lets not be doomed by these risks. Its better to fail after trying than to sit without trying.
                        </div>
                        <div class="chat-footer"></div>
                        <div class="chat-time-stamp">
                            9:13 AM
                        </div>
                    </div>
                </div>
                <div class="chat-container is-system">
                    <div class="chat-body">
                        <div class="chat-header">
                            <span class="chat-avatar">
                                <img src="{{ asset('/assets/frontend/img/crest-logo/fl.png') }}" alt="">
                            </span>
                            <span class="name">Fantasy League</span>
                        </div>
                        <div class="chat-preview"></div>
                        <div class="chat-content">
                            Mauris pharetra ultricies euismod. In at urna dictum, tristique mi ac, condimentum dui. Nulla enim nibh, luctus sed efficitur eget, dapibus placerat enim. Sed consequat ut magna in egestas. Sed consectetur risus consectetur tortor pharetra ornare. Donec finibus quam id consectetur varius.
                        </div>
                        <div class="chat-footer"></div>
                        <div class="chat-time-stamp">
                            9:13 AM
                        </div>
                    </div>
                </div>
                <div class="chat-container is-unread-count">
                    <div class="chat-body">
                        <div class="unread-badge">
                            <span>2 unread messeges</span>
                        </div>
                    </div>
                </div>
                <div class="chat-container is-user">
                    <div class="chat-body">
                        <div class="chat-preview"></div>
                        <div class="chat-content">
                            Mauris pharetra ultricies euismod. In at urna dictum, tristique mi ac, <a href="https://www.youtube.com/Bbji7wq">https://www.youtube.com/Bbji7wq</a>
                        </div>
                        <div class="chat-footer"></div>
                        <div class="chat-time-stamp">
                            9:13 AM
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="chat-footer">
        <div class="input-group">
            <div class="input-group-append attach_btn">
                <span class="input-group-text">
                    <i class="fas fa-paperclip"></i>
                </span>
                <input type="file" id="chat-attachment">
            </div>
            <textarea name="" class="form-control autofit" rows="1" placeholder="Type your message..."></textarea>
            <div class="input-group-append">
                <span class="input-group-text send_btn"><i class="fas fa-smile"></i></span>
            </div>
            <div class="input-group-append">
                <button type="button" class="input-group-text send_btn btn-primary">
                    <i class="fas fa-location-arrow"></i>
                </button>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@push ('modals')
<div class="chat-modal" id="chat" tabindex="-1" role="dialog" aria-labelledby="chat" aria-hidden="true">
    <div class="modal-card" role="document">
        <div class="dismiss-area" data-dismiss="modal" aria-label="Close"></div>
        <div class="modal-card-head">
            <div class="header">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <ul class="top-navigation-bar">
                                <li>
                                    <a href="javascript:void(0);" data-dismiss="modal" aria-label="Close">
                                        <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                                    </a>
                                </li>
                                <li class="text-center has-dropdown has-arrow">
                                    Chat
                                </li>
                                <li class="text-right">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-card-body">
            <div class="chat">
                <div class="chat-bg">
                    <div class="chat-img">
                        <img class="lazyload" src="{{ asset('assets/frontend/img/chat/chat-bg-thumb.png')}}" data-src="{{ asset('assets/frontend/img/chat/chat-bg.png')}}" alt="">
                        <div class="chat-overlay"></div>
                    </div>
                </div>
                <div class="chat-header">

                </div>
                <div class="chat-body">
                    <div class="chat-wrapper">
                        <div class="chat-area">
                            <div class="chat-container">
                                <div class="custom-alert alert-tertiary">
                                    <div class="alert-icon">
                                        <img src="{{ asset('assets/frontend/img/cta/icon-whistle.svg')}}" alt="alert-img">
                                    </div>
                                    <div class="alert-text">
                                        No one has said anything yet. How about starting the conservation.
                                    </div>
                                </div>
                            </div>
                            <div class="chat-container is-unread-count">
                                <div class="chat-body">
                                    <div class="unread-badge">
                                        <span>2 unread messeges</span>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-container is-sender">
                                <div class="chat-body">
                                    <div class="chat-header">
                                        <span class="name">Ed Will</span>
                                    </div>
                                    <div class="chat-preview"></div>
                                    <div class="chat-content">
                                        Its okay. Lets not be doomed by these risks. Its better to fail after trying than to sit without trying.
                                    </div>
                                    <div class="chat-footer"></div>
                                    <div class="chat-time-stamp">
                                        9:13 AM
                                    </div>
                                </div>
                            </div>
                            <div class="chat-container is-system">
                                <div class="chat-body">
                                    <div class="chat-header">
                                        <span class="chat-avatar">
                                            <img src="{{ asset('/assets/frontend/img/crest-logo/fl.png') }}" alt="">
                                        </span>
                                        <span class="name">Fantasy League</span>
                                    </div>
                                    <div class="chat-preview"></div>
                                    <div class="chat-content">
                                        Mauris pharetra ultricies euismod. In at urna dictum, tristique mi ac, condimentum dui. Nulla enim nibh, luctus sed efficitur eget, dapibus placerat enim. Sed consequat ut magna in egestas. Sed consectetur risus consectetur tortor pharetra ornare. Donec finibus quam id consectetur varius.
                                    </div>
                                    <div class="chat-footer"></div>
                                    <div class="chat-time-stamp">
                                        9:13 AM
                                    </div>
                                </div>
                            </div>
                            <div class="chat-container is-user">
                                <div class="chat-body">
                                    <div class="chat-preview"></div>
                                    <div class="chat-content">
                                        Mauris pharetra ultricies euismod. In at urna dictum, tristique mi ac, <a href="https://www.youtube.com/Bbji7wq">https://www.youtube.com/Bbji7wq</a>
                                    </div>
                                    <div class="chat-footer"></div>
                                    <div class="chat-time-stamp">
                                        9:13 AM
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-footer">
                    <div class="input-group">
                        <div class="input-group-append attach_btn">
                            <span class="input-group-text">
                                <i class="fas fa-paperclip"></i>
                            </span>
                            <input type="file" id="chat-attachment">
                        </div>
                        <textarea name="" class="form-control autofit" rows="1" placeholder="Type your message..."></textarea>
                        <div class="input-group-append">
                            <span class="input-group-text send_btn"><i class="fas fa-smile"></i></span>
                        </div>
                        <div class="input-group-append">
                            <button type="button" class="input-group-text send_btn btn-primary">
                                <i class="fas fa-location-arrow"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-card-foot">
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="footer-navigation">
                            <div class="navigation-tab">
                                    <a class="navigation-link" href="#">
                                        <span class="icon">
                                            <i class="fas fa-tshirt"></i>
                                        </span>
                                        <span>Team</span>
                                    </a>
                                </div>
                                <div class="navigation-tab">
                                    <a class="navigation-link" href="#">
                                        <span class="icon">
                                            <i class="fas fa-trophy"></i>
                                        </span>
                                        <span>League</span>
                                    </a>
                                </div>
                                <div class="navigation-tab">
                                    <a class="navigation-link" href="#">
                                        <span class="icon">
                                            <i class="fas fa-exchange-alt"></i>
                                        </span>
                                        <span>Transfers</span>
                                    </a>
                                </div>
                                <div class="navigation-tab">
                                    <a class="navigation-link" href="#">
                                        <span class="icon">
                                            <i class="fas fa-comment"></i>
                                        </span>
                                        <span>Chat</span>
                                    </a>
                                </div>
                                <div class="navigation-tab">
                                    <a class="navigation-link" href="#">
                                        <span class="icon">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </span>
                                        <span>More</span>
                                    </a>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush
