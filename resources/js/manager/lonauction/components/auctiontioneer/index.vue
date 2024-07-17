<template>
    <div>
    
        <div v-if="this.$store.getters.auctiontioneerScreen == 'start' || this.$store.getters.tempAuctiontioneerScreen == 'start'">
            <managers></managers>
        </div>

        <div v-if="this.$store.getters.auctiontioneerScreen != 'start' && this.$store.getters.tempAuctiontioneerScreen != 'start'">
            <player-auction :clubs="clubs" :positions="positions" :players="players" :division="division" :teamDetails="teamDetails" :maxClubPlayers="maxClubPlayers" :squadSize="squadSize"></player-auction>
        </div>

    </div>
</template>

<script>
    
    import managers from '../managers/managers.vue';
    import playerAuction from './auction.vue';

	export default {
        components: { managers, playerAuction },
        props: [ 'clubs', 'positions', 'players', 'division', 'teamDetails', 'maxClubPlayers', 'squadSize' ],
		data() {
			return {
			}
		},
        mounted() {
        },
        methods: {

        }
	};
</script>