<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Points Adjustments</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <h4>Add adjustment:</h4>
                <form class="js-point-adjustments-create-form" id="js-point-adjustments-create-form" action="{{ route('admin.point.adjustments.store') }}" method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="points" class="required">Points (+/-):</label>
                                <input type="text" class="form-control" id="points" name="points">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="note" class="required">Note:</label>
                                <input type="text" class="form-control" id="note" name="note" placeholder="Note">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="competition_type">Competition:</label>
                                <select name="competition_type" id="competition_type" class="form-control js-select2" style="width: 100%">
                                    @foreach($competition_types as $key => $type)
                                        <option value="{{$key}}">{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="team_id" value="{{$team->id}}">
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary btn-submit-point-adjustment"><i class="fa fa-check mr-5"></i>Save</button>
            <button type="button" class="btn btn-outline-secondary btn-show-point-adjustments-list">Cancel</button>
        </div>
    </div>
</div>

