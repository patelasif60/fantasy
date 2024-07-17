<template>
	<div v-if="playerAuctionData" v-cloak>
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
            <p class="bg-primary px-2 small">{{ secondsForRM }} seconds</p>
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
				secondsForRM: '',
				timestampForRM: '',
                interval: '',
                playerAuction: this.$store.getters.playerAuction
			}
		},
		computed: {
		},
		mounted() {
			var vm = this;
            vm.$store.dispatch('getCurrentTimestamp')

            setTimeout(function() {
				vm.timestampForRM = vm.$store.getters.currentTimestamp;

				var now  = moment.unix(vm.$store.getters.currentTimestamp).format("DD/MM/YYYY HH:mm:ss");
				var then = moment.unix(vm.$store.getters.rmBidTimestamp).format("DD/MM/YYYY HH:mm:ss");

				vm.secondsForRM = moment(then,"DD/MM/YYYY HH:mm:ss").diff(moment(now,"DD/MM/YYYY HH:mm:ss"), 'seconds')

				vm.interval = setInterval(() => {
			      vm.updateSecondsForRM();
			    }, 1000);
		    }, 500);
        },
        watch: {
        	playerAuction() {
        		this.playerAuction = this.$store.getters.playerAuction;
        	}
        },
        computed: {
        	playerAuctionData() {
        		return this.$store.getters.playerAuction;
        	}
        },
        methods: {
        	updateSecondsForRM: function(){
		    	this.secondsForRM--;
		    	this.timestampForRM++;

			    if (this.timestampForRM >= this.$store.getters.rmBidTimestamp) {
			        clearInterval(this.interval);

			        if(typeof this.playerAuctionData.remote_manager != "undefined") {
			        	var chkFlag = 0;
			        	_.forEach(this.playerAuctionData.remote_manager, function(bid) {
			        		if(bid != '' && bid > 0) {
			        			chkFlag++;
			        		}
			        	});
			        	if(chkFlag == 0) {
			        		var currManager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', this.playerAuctionData.opening_bid_manager_id]));
                    
		                    var teamId = this.checkNextManager(parseInt(currManager.order)+1);
		                    this.$store.dispatch('setCurrentBidManagerTeamID', teamId)


			        		this.$store.dispatch('updateManagerHighBid', '')

			        		let vm = this;
			        		setTimeout(function() {

			        			var currentManager = _.head(_.filter(vm.$store.getters.teamManagers, [ 'manager_id', vm.playerAuctionData.high_bidder_id ]));
			        			vm.$store.dispatch('updateTeamBudget', [vm.playerAuctionData, currentManager])	

			        		}, 500)			        		

			        		
			        	} else {
			        		this.$store.dispatch('updateManagerHighBid', 'displayBids')
			        	}
			        } else {
			        	this.$store.dispatch('updateManagerHighBid', 'displayBids')
			        }
			    }
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