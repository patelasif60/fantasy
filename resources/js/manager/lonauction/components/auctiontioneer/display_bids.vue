<template>
	<div v-if="playerAuctionData">
		<ul class="custom-list-group list-group-white mb-4">
	        <li>
	            <div class="list-element">
	                <span>Nominated player</span>
	                <span>{{ playerAuctionData.player }}</span>
	            </div>
	        </li>
	        <li>
	            <div class="list-element">
	                <span>Nominated by</span>
	                <span>{{ playerAuctionData.opening_bid_manager_name }}</span>
	            </div>
	        </li>
	        <li>
	            <div class="list-element">
	                <span>Highest bid</span>
	                <span>£{{ playerAuctionData.high_bid_value }}m</span>
	            </div>
	        </li>
	        <li>
	            <div class="list-element">
	                <span>Highest bidder</span>
	                <span>{{ playerAuctionData.high_bidder_name }}</span>
	            </div>
	        </li>
	    </ul>

	    <div class="d-flex justify-content-between align-items-center">
            <p class="font-weight-bold">Remote Bids</p>
            <p class="bg-primary px-2 small">Finished</p>
        </div>

        <ul class="custom-list-group list-group-white mb-4">
        	<li v-for="manager in this.$store.getters.remoteManagers">
                <div class="list-element">
					<span>{{ manager.first_name + " " +manager.last_name }}</span>
					<span v-if="playerAuctionData.remote_manager">
						<span v-if="playerAuctionData.remote_manager[manager.manager_id] > 0">
							£{{ playerAuctionData.remote_manager[manager.manager_id] }}m
						</span>
						<span v-if="playerAuctionData.remote_manager[manager.manager_id] == 0">
							Pass
						</span>
					</span>
					<span v-else>-</span>
				</div>
			</li>
        </ul>

		<p class="mb-4">
			Remote bidding has finished. {{ playerAuctionData.high_bidder_name }} is the new high bidder (£{{ playerAuctionData.high_bid_value }}m). Please invite new bids from the floor.
		</p>

		<p v-if="this.$store.getters.errorMsg" class="text-danger bg-white p-2">{{this.$store.getters.errorMsg}}</p>

		<div class="row mb-2 gutters-md">
	        <div class="col-sm-6">
                <button type="button" class="btn btn-outline-white btn-block" @click="noNewBids">No new bids</button>
            </div>

            <div class="col-sm-6 mt-2 mt-sm-0">
                <button type="button" class="btn btn-primary btn-block" @click="nextRound">Submit new high bid</button>
            </div>
	    </div>

	</div>
</template>

<script>
    var moment = require('moment');
    export default {
        components: {
        	
        },
        props: [ "squadSize" ],
		data() {
			return {
				playerAuction: this.$store.getters.playerAuction,
				currentRound: this.$store.getters.currentRound,
				form: {
					round: 0
				}
			}
		},
		mounted() {
			
        },
        watch: {
        	playerAuction() {
        		this.playerAuction = this.$store.getters.playerAuction;
        	},
        	currentRound() {
        		this.currentRound = this.$store.getters.currentRound;	
        	}
        },
        computed: {
        	playerAuctionData() {
        		return this.$store.getters.playerAuction;
        	},
        	currentRoundData() {
        		return this.$store.getters.currentRound;
        	}
        },
        methods: {
        	noNewBids: function() {
        		var currentManager = _.head(_.filter(this.$store.getters.teamManagers, [ 'manager_id', this.playerAuctionData.high_bidder_id ]));

        		this.$store.dispatch('updateTeamBudget', [this.playerAuctionData, currentManager])

        		var currManager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', this.playerAuctionData.opening_bid_manager_id]));
                    
                var teamId = this.checkNextManager(parseInt(currManager.order)+1);
                this.$store.dispatch('setCurrentBidManagerTeamID', teamId)
        	},
        	nextRound: function() {
        		this.form.round = parseInt(this.playerAuctionData.round)+1;
        		this.form.remote_manager = '';
        		this.$store.dispatch('updateplayerAuction', [this.form, 'highBid'])
        	},
        	checkNextManager: function(order) {
                if(this.$store.getters.teamManagers.length == order) {
                    order = 0;
                }
                var nextManager = _.head(_.filter(this.$store.getters.teamManagers, [ 'order', order ]));

                //check all players for all teams are filled or not
                var soldPlayers = this.$store.getters.soldPlayers.length + 1;
                var totalPlayers = this.$store.getters.teamManagers.length * parseInt(this.squadSize);


                if(soldPlayers < totalPlayers) {
                    if(typeof nextManager.squad_size == "undefined") {
                        if(nextManager.manager_id == this.playerAuctionData.high_bidder_id) {
                            nextManager.squad_size = 1;
                        } else {
                            nextManager.squad_size = 0;
                        }
                    } else {
                        if(nextManager.manager_id == this.playerAuctionData.high_bidder_id) {
                            nextManager.squad_size = parseInt(nextManager.squad_size) + 1;
                        }
                    }

                    if(nextManager.squad_size >= this.squadSize) {
                        return this.checkNextManager(order+1);
                    } else {
                        return nextManager.team_id;
                    }
                } else {
                    return nextManager.team_id;
                }
            },
        }
	};
</script>