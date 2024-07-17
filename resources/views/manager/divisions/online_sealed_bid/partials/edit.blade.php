<div class="modal nested-modal fade js-player-bid-modal-edit" tabindex="-1" role="dialog" aria-labelledby="bid-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
        <div class="modal-content">
            <form action="{{ route('manage.auction.online.sealed.bid.players.update',['division' => $division, 'team' => $team ]) }}" method="POST" class="js-player-bid-edit-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="bid_id" id="bid_id" value="{{ old('bid_id') }}">
                <input type="hidden" name="player_id" id="player_id_edit" value="{{ old('player_id') }}">
                <div class="modal-body">
                    <div class="player-bid-modal-body">
                        <div class="player-bid-modal-content">
                            <div class="player-bid-modal-label">
                                <div class="custom-badge custom-badge-xl is-square is-fb"></div>
                            </div>
                            <div class="player-bid-modal-body">
                                <div class="player-bid-modal-title"></div>
                                <div class="player-bid-modal-text"></div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('amount') ? ' is-invalid' : '' }} mb-3">
                            <label for="amount">Enter bid amount (&pound;m)</label>
                            <input type="text" class="form-control" id="amount_edit" name="amount" placeholder="e.g 15">
                            <input type="hidden" class="form-control" id="amount_edit_old" name="amount_edit_old" placeholder="e.g 15">
                            @if ($errors->has('amount'))
                                <span class="invalid-feedback animated fadeInDown" role="alert">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row gutters-sm">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</a>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block js-btn-update">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
