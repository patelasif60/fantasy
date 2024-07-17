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
            <li v-if="playerAuctionData.round == 1">
                <div class="list-element">
                    <span>Opening bid</span>
                    <span>£{{ playerAuctionData.opening_bid }}m</span>
                </div>
            </li>
            <li v-if="playerAuctionData.round > 1">
                <div class="list-element">
                    <span>Highest bid</span>
                    <span>£{{ playerAuctionData.high_bid_value }}m</span>
                </div>
            </li>
            <li v-if="playerAuctionData.round > 1">
                <div class="list-element">
                    <span>Highest bidder</span>
                    <span>{{ playerAuctionData.high_bidder_name }}</span>
                </div>
            </li>
        </ul>

        <p class="my-5">Waiting for managers in the room to submit their bids</p>

        <div class="loader"></div>

    </div>
</template>

<script>
    export default {
        components: {
            
        },
        props: [],
        data() {
            return {
                playerAuction: this.$store.getters.playerAuction
            }
        },
        mounted() {
            var vm = this;
            setTimeout(function() {
                vm.playerAuction = vm.$store.getters.playerAuction;
            }, 2000)    
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