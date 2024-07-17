<template>
	<div>
        <p>
            As auctioneer, you are able to edit any
            finished bidding rounds or cancel a bid
            entirely. If you edit a bid, the player will be
            returned to the player list and the transfer fee
            returned to the team.
        </p>

        <div class="form-group">
            <label for="nominated-player">Nominated player</label>
            <input type="text" class="form-control" id="nominated-player" name="nominated-player" placeholder="Harry Kane (TOT) ST" :value="player.player" readonly>
        </div>

        <div class="form-group">
            <label for="bidder">High bidder</label>
            <select class="js-bidder-select2 custom-select p-2 w-100" id="bidder" v-model="bidder">
                <option :value="manager.manager_id" v-for="manager in this.$store.getters.teamManagers">{{manager.first_name + " " + manager.last_name}}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="value">Value (£m)</label>
            <input type="text" class="form-control" id="newBidPrice" name="newBidPrice" placeholder="35" v-model.number="bidPrice" v-validate="'required'" :class="{ 'is-invalid': errors.has('newBidPrice') }">
        </div>

        <div class="row mb-2 gutters-md">
            <div class="col-sm-6">
                <button type="button" class="btn btn-danger btn-block" @click="cancelPlayerBid">Cancel bid</button>
            </div>
            <div class="col-sm-6 mt-2 mt-sm-0">
                <button type="button" :disabled="disableBtn" class="btn btn-primary btn-block" @click="updatePlayerBid">Save changes</button>
            </div>
        </div>
	</div>
</template>

<script>
    import VeeValidate from "vee-validate";
    
    Vue.use(VeeValidate);

    export default {
        components: {
        },
        props: ['player'],
        data() {
            return {
                disableBtn: false,
                playerId: 0,
                bidder: 0,
                bidPrice: 0,
                team_id: 0,
            }
		},
        mounted() {
            this.playerId = this.player.player_id;
            this.bidder = this.player.high_bidder_id;
            this.bidPrice = parseFloat(this.player.high_bid_value);
            this.disableBtn = false
        },
        methods: {
            updatePlayerBid() {

                if(this.player.high_bid_value == this.bidPrice && this.player.high_bidder_id == this.bidder) {
                    this.$emit('showBidEditForm', false);
                    return false;
                }

                this.$validator.validate().then(valid => {
                    if (valid) {

                        this.disableBtn = true

                        let manager = _.head(_.filter(this.$store.getters.teamManagers, [ 'manager_id', parseInt(this.bidder) ]));

                        let bidData = {
                            player_id: this.playerId,
                            bidder_id: this.bidder,
                            bid_price: this.bidPrice,
                            bidder_name: manager.first_name + " " + manager.last_name,
                            team_id: manager.team_id,
                            club_id: this.player.club_id,
                            position: this.player.position,
                        };

                        let bidValue = -1;
                        if(this.player.high_bidder_id != this.bidder) {
                            bidValue = (bidValue * parseFloat(this.player.high_bid_value))
                            
                            let oldBidValue = -1 * this.player.high_bid_value

                            let vm = this;
                            let divisionId = this.$store.getters.getDivisionId
                            axios.post(route('manage.lonauction.update.sold.player', {division: divisionId}), bidData)
                                .then((response) => {
                                    if(response.data.success == true) {
                                        vm.$store.dispatch('updateTeamBudgetInFCM', {team_id: vm.player.team_id, bid_value: oldBidValue})

                                        vm.$store.dispatch('updateTeamBudgetInFCM', {team_id: bidData.team_id, bid_value: bidData.bid_price})
                                    }
                                })
                                .catch((error) => {
                                    console.log(error)
                                });
                        } else {

                            if(this.player.high_bid_value > this.bidPrice) {
                                bidValue = bidValue * (this.player.high_bid_value - this.bidPrice)
                            } else {
                                bidValue = this.bidPrice - this.player.high_bid_value
                            }

                            let vm = this;
                            let divisionId = this.$store.getters.getDivisionId
                            axios.post(route('manage.lonauction.update.sold.player', {division: divisionId}), bidData)
                                .then((response) => {
                                    if(response.data.success == true) {
                                        vm.$store.dispatch('updateTeamBudgetInFCM', {team_id: vm.player.team_id, bid_value: bidValue})
                                    }
                                })
                                .catch((error) => {
                                    console.log(error)
                                });
                        }

                        this.$store.dispatch('updatePlayerBid', bidData)
                        this.$emit('showBidEditForm', false);
                    }
                    else {
                        console.log('ERROR!!')
                    }
                });
            },
            cancelPlayerBid() {

                let bidData = {
                    player_id: this.player.player_id,
                    bidder_id: this.player.high_bidder_id,
                    team_id: this.player.team_id,
                    club_id: this.player.club_id,
                    position: this.player.position,
                };

                let vm = this;
                let divisionId = this.$store.getters.getDivisionId
                axios.post(route('manage.lonauction.delete.sold.player', {division: divisionId}), bidData)
                    .then((response) => {
                        if(this.$store.getters.isCloseAuction) {
                            vm.$store.dispatch('setCurrentBidManagerTeamID', vm.player.team_id)
                        }

                        vm.$store.dispatch('cancelPlayerBid', vm.player.player_id)

                        let bidValue = -1 * vm.player.high_bid_value
                        vm.$store.dispatch('updateTeamBudgetInFCM', {team_id: vm.player.team_id, bid_value: bidValue, set_bids_won: true})

                        vm.$store.dispatch('updateIsCloseAuction', false)

                        vm.$emit('showBidEditForm', false);
                    })
                    .catch((error) => {
                        console.log(error)
                    });
            }
        }
	};
</script>