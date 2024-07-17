<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Teams</h3>
        <div class="block-options">
            @if(auth()->user()->can('checkMaxTeamsQuota', $division))
                <button href="{{ route('admin.divisions.team.create',['division' => $division, 'season' => $defaultSeason]) }}" class="btn btn-outline-primary add-team-btn fetch_create_edit_modal"><i class="fal fa-plus mr-5"></i>Add Team</button>
            @endif
            <a href="" class="btn btn-outline-primary exportCsv"><i class="fa fa-plus mr-5"></i>Export to CSV</a>
        </div>
    </div>
    <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter table-hover admin-divisions-team-list-table" data-url="{{ route('admin.division.team.data') }}"></table>
    </div>
</div>


