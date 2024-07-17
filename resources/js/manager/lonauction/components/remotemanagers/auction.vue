<template>
	<div v-cloak>
		<div v-if="currentAuctionScreen == 'start'">
            <startPage></startPage>
		</div>
		
		<div class="row align-items-center justify-content-center" v-if="currentAuctionScreen != 'start' && isManagerRemoteManager == 0">
			<presentManagers :clubs="clubs" :positions="positions" :players="players" :division="division" :teamDetails="teamDetails"></presentManagers>
		</div>

	    <div class="row align-items-center justify-content-center" v-if="currentAuctionScreen != 'start' && isManagerRemoteManager == 1">
	        <div class="col-12">
	            <div class="container-wrapper">
	                <div class="container-body">
	                    <div class="row mt-1 text-white">
	                        <div class="col-12">

	                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary mb-4" id="pills-tab" role="tablist">
	                                <li class="nav-item">
	                                    <a class="nav-link active" id="auctioneer-tab" data-toggle="pill" href="#auctioneer" role="tab" aria-controls="auctioneer" aria-selected="true">Auctioneer</a>
	                                </li>
	                                <li class="nav-item">
	                                    <a class="nav-link" id="team-tab" data-toggle="pill" href="#team" role="tab" aria-controls="team" aria-selected="false">Teams</a>
	                                </li>
	                                <li class="nav-item">
	                                    <a class="nav-link" id="player-tab" data-toggle="pill" href="#player" role="tab" aria-controls="player" aria-selected="false">Players</a>
	                                </li>
	                            </ul>

	                             <div class="tab-content" id="pills-tabContent">

	                                <div class="tab-pane fade show active" id="auctioneer" role="tabpanel" aria-labelledby="auctioneer-tab">
	                                	<template v-if="isCloseAuction || isCloseAuction == 'true'">
	                                        <closeAuction :role="'user'"></closeAuction>    
	                                    </template>
	                                    <template v-else>

		                                    <div v-if="currentAuctionScreen == 'nominatePlayer'">
						                        <remotenominateplayer :clubs="clubs" :positions="positions" :players="players" :division="division" :teamDetails="teamDetails" :maxClubPlayers="maxClubPlayers" :squadSize="squadSize" v-if="currentBidManager == currentBidManagerTeamID"></remotenominateplayer>

						                        <nominatePlayer v-else></nominatePlayer>

											</div>

											<div v-else-if="currentAuctionScreen == 'highBid'">
												<highBid></highBid>
											</div>

											<div v-else-if="currentAuctionScreen == 'remoteBids'">
												<remoteBids :teamDetails="teamDetails" :maxClubPlayers="maxClubPlayers" :squadSize="squadSize"></remoteBids>
											</div>

											<div v-else-if="currentAuctionScreen == 'displayBids'">
												<displayBids></displayBids>
											</div>
											
											<div v-else-if="currentAuctionScreen == 'bidWinner'">
												<bidWinner></bidWinner>
											</div>
										</template>

	                                </div>

	                                <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">
	                                	
	                                	<teamList v-if="showTeamList" @showTeamPlayers="showTeamPlayers"></teamList>
                                		<teamPlayers :currentTeamID="currentTeamID" @showTeamList="showTeamList = $event" v-else></teamPlayers>

	                                </div>
	                                <div class="tab-pane fade" id="player" role="tabpanel" aria-labelledby="player-tab">
	                                	
	                                	<allPlayers :clubs="clubs" :positions="positions" :players="players" :division="division" :teamDetails="teamDetails"></allPlayers>

	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

	</div>
</template>

<script>
	import startPage from "../../start.vue";
    import nominatePlayer from "./nominate_player.vue";
    import remotenominateplayer from './remote_nominate_player.vue';
    import highBid from "./high_bid.vue";
    import remoteBids from "./remote_bids.vue";
    import displayBids from "./display_bids.vue";
    import bidWinner from "./bid_winner.vue";
    import presentManagers from "../presentmanagers/index.vue";
    import teamList from "../auctiontioneer/teamlist.vue";
    import teamPlayers from "../auctiontioneer/teamplayers.vue";
    import allPlayers from "../auctiontioneer/all_players.vue";
    import closeAuction from "../auctiontioneer/close_auction.vue";

    export default {
        components: {
        	startPage, nominatePlayer, highBid, remoteBids, displayBids, bidWinner, remotenominateplayer, presentManagers, teamList, teamPlayers, allPlayers, closeAuction
        },
        props: ['clubs', 'positions', 'players', 'division', 'teamDetails', 'maxClubPlayers', 'squadSize'],
		data() {
			return {
				auctionScreen: this.$store.getters.auctiontioneerScreen,
				currentBidManager: this.teamDetails.id,
				currentBidManagerID: this.$store.getters.currentBidManagerTeamID,
				currentManagerIsRemote: 0,
				showTeamList: true,
                currentTeamID: 0,
                checkCloseAuction: this.$store.getters.isCloseAuction
			}
		},
        mounted() {
        	this.$store.dispatch('setCurrentPlayerAuctionData')
        	var vm = this;
        	setTimeout(function() {
        		var manager = _.head(_.filter(vm.$store.getters.teamManagers, ['team_id', vm.currentBidManager]));
        		vm.currentManagerIsRemote = manager.is_remote;
        	}, 500);
        },
        computed: {
        	isCloseAuction() {
                return this.$store.getters.isCloseAuction
            },
        	currentAuctionScreen() {
        		return this.$store.getters.auctiontioneerScreen
        	},
        	currentBidManagerTeamID() {
        		return this.$store.getters.currentBidManagerTeamID
        	},
        	isManagerRemoteManager() {
        		var manager = _.head(_.filter(this.$store.getters.teamManagers, ['team_id', this.currentBidManager]));
        		return manager.is_remote;
        	}
        },
        methods: {
            back() {
            },
            showTeamPlayers(event) {
                this.currentTeamID = event
                this.showTeamList = false
            }
        }
	};
</script>