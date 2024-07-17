<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Add Team</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form class="js-divison-team-create-form" id="js-divison-team-create-form" action="{{ route('admin.division.team.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="block">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-season_id" class="required">Season:</label>
                                        <select name="season_id" id="filter-season_id" class="form-control js-select2" style="width: 100%">
                                                <option value="">Please Select</option>
                                                @foreach($seasons as $id => $season)
                                                    <option value="{{ $id }}">{{ $season }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="filter-team_id" class="required">Team:</label>
                                        <select name="team_id" id="filter-team_id" class="form-control js-select2" style="width: 100%">
                                                <option value="">Please Select</option>
                                                @foreach($teams as $id => $team)
                                                    <option value="{{ $team->id }}">{{ $team->name }} ({{$team->consumer->user->first_name.' '.$team->consumer->user->last_name}})</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="division_id" value="{{$division_id}}">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-hero btn-outline-primary js-modal-create-team-box"><i class="fal fa-plus mr-5"></i>Add New Team</button>
            <button type="submit" id="create-team-button" class="btn btn-hero btn-noborder btn-default" data-form="#js-divison-team-create-form">Save</button>
        </div>
    </div>
</div>

