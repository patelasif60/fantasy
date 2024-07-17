@extends('layouts.admin')

@section('content')
@include('flash::message')
 <!-- Fade In Modal -->
<div class="modal modal-fullscreen fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Header</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-content">
                        <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                    <i class="fa fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END Fade In Modal -->
<div class="row">
    <div class="col-sm-4">
        <div class="block">
            <div class="block-content">
                <p class="text-center py-100">...</p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="block">
            <div class="block-content">
                <p class="text-center py-100">...</p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="block">
            <div class="block-content">
                <p class="text-center py-100">...</p>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="block">
            <div class="block-content">
                <p class="text-center py-100">...</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="block">
            <div class="block-content">
                <p class="text-center py-100">...</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="block">
            <div class="block-content">
                <p class="text-center py-100">...</p>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="block">
            <div class="block-content">
                <p class="text-center py-100">...</p>
            </div>
        </div>
    </div>
</div>
@endsection
