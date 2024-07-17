<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content theme-modal">
        <div class="modal-close-area">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
            </button>
            <div class="f-12">Close</div>
        </div>
        <div class="modal-header">
            <h5 class="modal-title">Invite Your Friends</h5>
        </div>
        <div class="modal-body pt-0">
            <p>To invite other managers to your league, please share your unique link below.</p>
            <div class="snippet code-copy">
                <span id="invite_code">{{route('manager.division.join.a.league', ['code' => $code])}}</span>
            </div>
            <div class="row gutters-md">
                <div class="col-md-6">
                    <button class="btn btn-secondary btn-block has-icon copy-invite-code">
                        <i class="far fa-clipboard mr-2"></i>Copy Link
                    </button>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <a class="btn btn-secondary btn-block has-icon" id="shareCode" data-url="{{route('manager.division.join.a.league', ['code' => $code])}}" data-text="Join my league with this link " data-title="Join my league" href="JavaScript:void(0);">
                        <i class="far fa-share-alt mr-2"></i>Share code
                    </a>
                    <div class="row gutters-md justify-content-center d-none share-via mt-25">
                        <div class="col-sm-6">
                            <a class="btn btn-secondary btn-block has-icon" href="mailto:?subject=Fantasy%20League%20-%20Join%20My%20League&amp;body=I’m%20throwing%20down%20the%20gauntlet.%20Go%20to%20{{route('manager.division.join.a.league', ['code' => $code])}}%20to%20join%20my%20Fantasy%20League.%0A%0AThe%20invitation%20code%20is {{$code}}.%0A%0AFantasy%20League%20is%20the%20true%20test%20of%20fantasy football%20prowess%20from%20our%20player%20auction%20all%20the%20way%20through%20a%20season%20competing%20with%20unique%20squads%20to%20show%20who’s%20best.%20See%20{{route('frontend')}}%20for%20more%20details.%0A%0ASee%20you%20at%20our%20player%20auction!">
                                <i class="far fa-envelope mr-2"></i> Email
                            </a>
                        </div>
                        @mobile
                        <div class="col-sm-6 mt-2 mt-sm-0">
                            <a class="btn btn-secondary btn-block has-icon" href="sms:?body=Join my league with this link {{route('manager.division.join.a.league', ['code' => $code])}}">
                                <i class="fas fa-envelope mr-2"></i>Text Message
                            </a>
                        </div>
                        @endmobile
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
