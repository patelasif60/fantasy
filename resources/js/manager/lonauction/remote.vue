<template>
        <remoteBids></remoteBids>
</template>

<script>

    import remoteBids from './components/remotemanagers/remoteBids.vue';

	export default {
        components: { remoteBids },
        props: ['teamManagers'],
		data() {
			return {
                step: 2,
                auctionDetails: {
                    player: {
                        name: "Harry Kane (TOT) ST",
                        id: 10,
                    },
                    nominatedBy: {
                        name: "Ben Grout",
                        id: 20,
                    },
                    openingBid: 25,
                },
			}
		},
        created() {
            this.$store.dispatch('sortedTeamManagers', this.teamManagers)
        },
        mounted() {            
        },
        methods: {
            
        }
	};
</script>