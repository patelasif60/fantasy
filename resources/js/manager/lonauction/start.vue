<template>
	<div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <p class="text-white">Your league auction is scheduled to begin on {{ startAuctionTime }}.</p>
                            <p class="text-white">The auction format is Live Online. You are nominated as the auctioneer.</p>
                            <p class="text-white">Once the auction is completed you will be able to manage your team.</p>
                        </div>
                    </div>
                </div>

                <div class="container-body">
                    <div class="mb-2" v-if="userRole == 'auctiontioneer' && isAuctionSet && isInAuctionState">
                        <button type="submit" class="btn btn-primary btn-block" @click="startAuction">
                            Start auction now
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        components: {  },
        props: [ 'startAuctionTime', 'isAuctionSet',  'isInAuctionState', 'userRole' ],
		data() {
			return {

			}
		},
        created() {
        },
        mounted() {            
        },
        methods: {
            startAuction() {
                this.$store.dispatch('changeAuctiontioneerScreen', 'start')
            }
        }
	};
</script>