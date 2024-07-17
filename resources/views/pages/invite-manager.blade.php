@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12 text-white">
                            <div class="f-14 font-weight-bold">Enter contact details below and we will send your friends a link to join your league.</div>
                            <div class="f-14">Alternatively please tell your friends to install the Fantasy League app and enter the following code:</div>
                            <div class="snippet code-copy">
                                X578DF148
                                <a href="" class="btn btn-copy">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <div class="f-12 mr-1">Share code</div>
                                <a class="text-white" data-toggle="modal" data-target="#ShareCodeModal">
                                    <i class="far fa-share-alt"></i>
                                </a>
                            </div>
                            <form class="mt-50" action="" method="POST">
                                <div class="form-group">
                                    <label for="invitation-code">Phone Number or Email Address</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="email" class="form-control border-right-0" placeholder="Recipient's email" id="" name="" value="joebloggs@domain.com" aria-label="Invitee's email">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white">
                                                <i class="far fa-minus-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="email" class="form-control border-right-0" placeholder="Recipient's email" id="" name="" value="joebloggs@gmail.com" aria-label="Invitee's email">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white">
                                                <i class="far fa-minus-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a class="d-flex align-items-center justify-content-end link-nostyle" href="#">
                                        Add another
                                        <span class="input-group-text bg-transparent border-0 text-white">
                                            <i class="far fa-plus-circle"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Send Invitation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('modals')
<div class="modal fade" id="ShareCodeModal" tabindex="-1" role="dialog" aria-labelledby="ShareCodeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content theme-modal">
            <div class="modal-close-area">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                </button>
                <div class="f-12">Close</div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">Share your code</h5>
            </div>
            <div class="modal-body">
                <p>
                    Nam varius tincidunt convallis. Praesent vitae nibh sodales ligula rutrum tincidunt. Suspendisse massa turpis, laoreet et nibh a, ornare scelerisque odio.
                </p>
                <p class="font-weight-bold">
                    Quisque a ultricies velit. Nunc porttitor, ipsum a posuere blandit, libero eros iaculis elit, et eleifend sem elit id quam.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endpush
