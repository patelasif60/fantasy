
 <!-- Modal -->
    <div class="modal fade nested-modal js-detail-player-bid-modal" tabindex="-1" role="dialog" aria-labelledby="edit-bid-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="player-bid-modal-body">
                        <form action="" method="POST" class="js-player-bid-detail-form">
                            @csrf
                            <div class="player-bid-modal-content">
                                <div class="player-bid-modal-label">
                                    <div class="custom-badge custom-badge-xl positionJs is-square"></div>
                                </div>
                                <div class="player-bid-modal-body">
                                    <div class="player-bid-modal-title"></div>
                                    <div class="player-bid-modal-text"></div>
                                </div>
                            </div>

                            <div class="my-3">
                                <button type="button" class="btn btn-primary btn-block edit-button-modal">Edit bid</button>
                            </div>

                            <div class="row gutters-sm">
                                <div class="col-sm-6 mt-3 mt-sm-0 order-last order-sm-first">
                                    <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-tertiary btn-block delete-confirmation-button" data-dismiss="modal">Remove bid</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
