<template>
	<div v-if="auction.playerAuction" v-cloak>

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

        <p class="my-4">Waiting for Round {{ typeof currentRoundData == 'undefined' ? 2 : currentRoundData}} to begin</p>

        <div class="mb-2"><div class="loader"></div></div>

	</div>
</template>

<script>
    
    export default {
        components: {
        	
        },
        props: [],
		data() {
			return {
				auction: this.$store.getters,
                currentRound: this.$store.getters.currentRound,
			}
		},
		mounted() {
            var vm = this;
        },
        watch: {
            currentRound() {
                this.currentRound = this.$store.getters.currentRound;   
            }
        },
        computed: {
            currentRoundData() {
                return this.$store.getters.currentRound;
            }
        },
        methods: {
        	
        }
	};
</script>