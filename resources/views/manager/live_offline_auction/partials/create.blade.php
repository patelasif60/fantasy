
    <div class="modal fade nested-modal js-create-player-bid-modal" tabindex="-1" role="dialog" aria-labelledby="bid-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
            <div class="modal-content">

                    <div class="modal-body">
                        <div class="player-bid-modal-body">

                            <form action="{{ route('manage.division.team.auction.create', ['division' => $division, 'team' => $team]) }}" method="POST" class="js-player-bid-create-form">
                                @csrf
                                <input type="hidden" name="player_id" id="player_id" value="{{ old('player_id') }}">
                                <input type="hidden" name="team_id" id="team_id" value="{{ $team->id }}">
                                <input type="hidden" name="club_id" id="club_id" value="{{ old('club_id') }}">
                                <div class="player-bid-modal-content">
                                    <div class="player-bid-modal-label">
                                        <div class="custom-badge custom-badge-xl is-square positionJs"></div>
                                    </div>
                                    <div class="player-bid-modal-body">
                                        <div class="player-bid-modal-title"></div>
                                        <div class="player-bid-modal-text"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-group mb-3{{ $errors->has('amount') ? ' is-invalid' : '' }}">
                                        <label for="amount">Enter bid amount (&pound;m)</label>
                                        <input type="text" class="form-control" id="amount" name="amount" value="0" placeholder="e.g. 0.5">
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback animated fadeInDown" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="row gutters-sm">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary btn-block createBtn">OK</button>
                                        </div>
                                    </div>


                                </div>
                            </form>
                        </div>

                    </div>
            </div>
        </div>
    </div>
