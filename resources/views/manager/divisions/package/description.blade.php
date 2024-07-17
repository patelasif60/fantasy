<div class="modal-dialog" role="document">
    <div class="modal-content theme-modal">
        <div class="modal-close-area">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
            </button>
            <div class="f-12">Close</div>
        </div>
        <div class="modal-header">
            <h5 class="modal-title">Package description</h5>
        </div>

        <div class="modal-body">
            <input type="hidden" id="modal_package_id" value="{{$package->id}}">
            <h6>{{$package->name}}</h6>
            <p>{{$package->long_description}}</p>
        </div>

        <div class="modal-footer">
            <a href="{{ route('manage.division.create', ['package' => $package]) }}" class="btn btn-primary btn-block">Create league</a>
        </div>
    </div>
</div>
