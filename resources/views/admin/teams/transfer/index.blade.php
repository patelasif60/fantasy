<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Transfers and Activity</h3>
        <div class="block-options">
            <button href="{{ route('admin.team.transfer.create',['team' => $team]) }}" class="btn btn-outline-primary add-team-btn fetch_create_edit_modal"><i class="fal fa-plus mr-5"></i>Add Transfers and Activity</button>
            <a href="" class="btn btn-outline-primary exportCsv"><i class="fa fa-plus mr-5"></i>Export to CSV</a>
        </div>
    </div>
</div>

<div class="block">
    <form action="#" class="block-header block-header-default js-filter-form" method="POST">
        <div class="block-options">
            <div class="form-group mb-0">
                <div class="row no-gutters items-push">
                     @foreach($transfer_type as $key => $type)
                        <label class="css-control css-control-primary css-checkbox">
                        <input type="checkbox" class="css-control-input transfer-types" value="{{$key}}" id="transfer_types-{{$key}}" name="transfer_types[]" checked="">
                        <span class="css-control-indicator"></span> {{$type}}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </form>    
    <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter table-hover admin-teams-transfer-list-table" data-url="{{ route('admin.team.transfer.data') }}"></table>
    </div>
</div>        

   