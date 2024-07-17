<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Rollover leagues</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        <form class="js-season-rollover-form" action="{{ route('admin.seasons.rollover', ['season' => $season]) }}" method="post">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
           <div class="block-content">
                <div class="alert alert-danger alert-important">
                    <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                    This action will clone leagues, divisions, and teams from the selected seasons to {{ $season->name }}
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('duplicate_from') ? ' is-invalid' : '' }}">
                            <label for="duplicate_from" class="required">Duplicate from season:</label>
                            <select class="form-control js-select2" id="duplicate_from" name="duplicate_from">
                                <option value="">Please select</option>
                                @foreach($seasons as $id => $options)
                                    <option value="{{ $options->id }}">{{ $options->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('duplicate_from'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('duplicate_from') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-hero btn-noborder btn-primary">Start rollover</button>
                <a href="#" class="btn btn-hero btn-noborder btn-alt-secondary" data-dismiss="modal">Close</a>
            </div>
        </form>
    </div>
</div>
