<template>
    <div v-if="currentScreen">
        <div v-if="this.$store.getters.auctiontioneerScreen == 'notStarted'">
            <startPage :startAuctionTime="startAuctionTime" :isAuctionSet="isAuctionSet" :isInAuctionState="isInAuctionState" :userRole="userRole"></startPage>
        </div>

        <div v-else>
            <div v-if="userRole == 'manager'" v-cloak>
                <remoteManager :clubs="clubs" :positions="positions" :players="players" :division="division" :teamDetails="teamDetails" :maxClubPlayers="maxClubPlayers" :squadSize="squadSize" v-if="this.$store.getters.teamManagers.length"></remoteManager>
            </div>
            <div v-else-if="userRole == 'auctiontioneer'" v-cloak>
                <auctiontioneer :clubs="clubs" :positions="positions" :players="players" :division="division" :teamDetails="teamDetails" :maxClubPlayers="maxClubPlayers" :squadSize="squadSize" v-if="this.$store.getters.teamManagers.length"></auctiontioneer>
            </div>
        </div>
    </div>
</template>

<script>

    import startPage from './start.vue';
    import auctiontioneer from './components/auctiontioneer/index.vue';
    import remoteManager from './components/remotemanagers/auction.vue';

	export default {
        components: { startPage, auctiontioneer, remoteManager },
        props: ['startAuctionTime', 'isAuctionSet', 'isInAuctionState', 'teamManagers', 'userRole', 'division', 'teamDetails', 'clubs', 'positions', 'players', 'maxClubPlayers', 'squadSize', 'isCloseAuction'],
		data() {
			return {
			}
		},
        created() {
            if(this.userRole == 'manager') {
                this.$store.dispatch('setManagerScreen', this.division)
            } else {
                this.$store.dispatch('addTeamManagers', [this.teamManagers, this.division])
            }
            this.$store.dispatch('updateIsCloseAuction', this.isCloseAuction)
        },
        computed: {
            currentScreen() {
                return this.$store.getters.auctiontioneerScreen != ""
            }
        },
        mounted() {
        },
        methods: {
        }
	};
</script>