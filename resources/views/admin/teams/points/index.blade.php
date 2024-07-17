<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Points</h3>
        <div class="block-options">
        	{{-- <a href="" class="btn btn-outline-primary adjustPoints"><i class="fa fa-settings mr-5"></i>Points adjustment</a> --}}
            <button href="{{ route('admin.point.adjustments.table',['team'=>$team]) }}" class="btn btn-outline-primary add-team-btn show-point-adjustments-table"><i class="fal fa-cog mr-5"></i>Points adjustment</button>
            <a href="" class="btn btn-outline-primary exportCsv"><i class="fa fa-plus mr-5"></i>Export to CSV</a>
        </div>
    </div>
</div>
<div class="block">    
    <div class="block-content block-content-full">
        <table id='testPlayer' class="table table-striped table-vcenter table-hover admin-team-points-list-table" data-url="{{route('admin.team.points.data')}}"></table>
    </div>
</div>

@push('modals')
<div class="modal fade" id="modal-create-edit-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
</div>
@endpush