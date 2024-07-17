@extends('layouts.auth.selection')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li></li>
                                    <li class="text-center">Invite your friends</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center text-white mt-3">
                            <div class="col-12 col-md-11">
                                <p class="f-14 font-weight-bold">To invite other managers to your league, please share your unique URL.</p>
                                <div class="snippet code-copy">
                                    <span id="invite_code">fantasyleague.com/join/AAB323</span>
                                </div>
                                <div class="row gutters-md">
                                    <div class="col-6">
                                        <a href="#" class="btn btn-secondary btn-block has-icon">
                                            <i class="far fa-clipboard"></i>  Copy URL
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" class="btn btn-secondary btn-block has-icon" data-toggle="modal" data-target="#shareModal">
                                            <i class="fas fa-share-alt"></i> Share code
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auth-card-content">
                    <div class="auth-card-footer">
                        <div class="row justify-content-center text-white mt-3">
                            <div class="col-12 col-md-11">
                                <div class="row gutters-md mt-4">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-secondary btn-block">Back</button>
                                    </div>
                                    <div class="col-md-6 pt-3 pt-md-0">
                                        <button type="submit" class="btn btn-primary btn-block">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
    <script>
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            // alert("Hi");
            $('.send-message-block').removeClass("d-none");
        }
        else {
            $('.send-message-block').addClass("d-none");
        }
    </script>
@endpush

@push ('modals')
    <!-- Modal -->
    <div class="modal fade share-modal" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header align-items-center border-bottom">
                    <h6 class="m-0">Share Code Via</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row gutters-md justify-content-center">
                        <div class="col-sm-6">
                            <a href="mailto:example@gmail.com" class="btn btn-secondary btn-block has-icon">
                                <i class="far fa-envelope"></i>  Email
                            </a>
                        </div>
                        <div class="col-sm-6 mt-2 mt-sm-0 send-message-block d-none">
                            <a href="sms:+1-999-999-9999" class="btn btn-secondary btn-block has-icon">
                                <i class="fas fa-envelope"></i> Text Message
                            </a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endpush
