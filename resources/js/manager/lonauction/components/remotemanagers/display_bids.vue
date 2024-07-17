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

		<p class="my-4">Waiting for managers in the room to submit their bids</p>

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
				playerAuction: this.$store.getters.playerAuction,
			}
		},
		mounted() {
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
        	
        }
	};
</script>