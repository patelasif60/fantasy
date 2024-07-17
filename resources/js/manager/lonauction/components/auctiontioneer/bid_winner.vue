<template>
	<div v-if="auction.playerAuction">
		<div class="custom-alert alert-tertiary">
            <div class="alert-icon">
                <img src="/assets/frontend/img/cta/icon-whistle.svg" alt="alert-img">
            </div>
            <div class="alert-text text-body">
                {{ auction.playerAuction.high_bidder_name }} has won the bidding for {{ auction.playerAuction.player }} with a bid of £{{ auction.playerAuction.high_bid_value }}m
            </div>
        </div>

        <ul class="custom-list-group list-group-white mb-4">
            <li>
                <div class="list-element">
                    <span>Nominated player</span>
                    <span>{{ auction.playerAuction.player }}</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Nominated by</span>
                    <span>{{ auction.playerAuction.opening_bid_manager_name }}</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Highest bid</span>
                    <span>£{{ auction.playerAuction.high_bid_value }}m</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Highest bidder</span>
                    <span>{{ auction.playerAuction.high_bidder_name }}</span>
                </div>
            </li>
        </ul>
        
		<div class="row mb-2 gutters-md">        
            <div class="col-sm-6">
                <button type="button" class="btn btn-outline-white btn-block" @click="changeRemoteManagers">Change remote managers</button>
            </div>

            <div class="col-sm-6 mt-2 mt-sm-0">
                <button type="button" class="btn btn-primary btn-block h-100" @click="nextRound">Begin round {{ typeof auction.currentRound == 'undefined' ? 2 : auction.currentRound}}</button>
            </div>
	    </div>

	</div>
</template>

<script>
    
    export default {
        components: {
        	
        },
        props: [],
		data() {
			return {
				auction: this.$store.getters
			}
		},
		computed: {
		    
		},
		mounted() {
        },
        methods: {
        	changeRemoteManagers() {
        		this.$store.dispatch('tempAuctiontioneerScreen', 'start')
        	},
        	nextRound() {
        		this.$store.dispatch('finishBidProcess')
        	}
        }
	};
</script>