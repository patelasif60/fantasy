<template>

	<div class="row align-items-center justify-content-center" v-cloak >
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

                                <li class="nav-item">
                                    <a class="nav-link" id="bid-tab" data-toggle="pill" href="#bid" role="tab" aria-controls="bid" aria-selected="false">Bids</a>
                                </li>
                            </ul>

                             <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="auctioneer" role="tabpanel" aria-labelledby="auctioneer-tab">

                                    <template v-if="isCloseAuction || isCloseAuction == 'true'">
                                        <closeAuction :role="'auctiontioneer'"></closeAuction>    
                                    </template>
                                    <template v-else>
                                        <div v-if="this.$store.getters.auctiontioneerScreen == 'nominatePlayer'">
                                            <nominatePlayer :maxClubPlayers="maxClubPlayers" :squadSize="squadSize" v-if="currentBidManagerData.is_remote == 0"></nominatePlayer>
                                            <rmNominatePlayer :currentBidManager="currentBidManager"  :squadSize="squadSize" v-else></rmNominatePlayer>
                                        </div>

                                        <div v-else-if="this.$store.getters.auctiontioneerScreen == 'highBid'">
                                            <highBid :squadSize="squadSize"></highBid>
                                        </div>

                                        <div v-else-if="this.$store.getters.auctiontioneerScreen == 'remoteBids'">
                                            <remoteBids :squadSize="squadSize"></remoteBids>
                                        </div>

                                        <div v-else-if="this.$store.getters.auctiontioneerScreen == 'displayBids'">
                                            <displayBids :squadSize="squadSize"></displayBids>
                                        </div>
                                        
                                        <div v-else-if="this.$store.getters.auctiontioneerScreen == 'bidWinner'">
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
                                
                                <div class="tab-pane fade" id="bid" role="tabpanel" aria-labelledby="bid-tab">
									<soldPlayers v-if="!showEditPlayerBidForm" @showBidEditForm="showBidEditForm"></soldPlayers>
	                    			<editPlayerBid v-if="showEditPlayerBidForm" @showBidEditForm="showEditPlayerBidForm = $event" :player="player"></editPlayerBid>
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
    import nominatePlayer from "./nominate_player.vue";
    import rmNominatePlayer from "./remote_opening_bid.vue";
    import highBid from "./high_bid.vue";
    import remoteBids from "./remote_bids.vue";
    import displayBids from "./display_bids.vue";
    import bidWinner from "./bid_winner.vue";
    import soldPlayers from "./sold_players.vue";
    import editPlayerBid from "./edit_player_bid.vue";
    import teamList from "./teamlist.vue";
    import teamPlayers from "./teamplayers.vue";
    import allPlayers from "./all_players.vue";
    import closeAuction from "./close_auction.vue";

    export default {
        components: {
        	nominatePlayer, highBid, remoteBids, displayBids, bidWinner, soldPlayers, editPlayerBid, rmNominatePlayer, teamList, teamPlayers, allPlayers, closeAuction
        },
        props: [ 'clubs', 'positions', 'players', 'division', 'teamDetails', 'maxClubPlayers', 'squadSize' ],
		data() {
			return {
                showTeamList: true,
                currentTeamID: 0,
				showEditPlayerBidForm: false,
                currentBidManager: _.head(_.filter(this.$store.getters.teamManagers, [ 'order', parseInt(this.$store.getters.currentBidManagerIndex) ])),
				player: {
					player: '',
					high_bid_value: 0,
				},                
			}
		},
        watch: {
            currentBidManager() {
                this.currentBidManager = _.head(_.filter(this.$store.getters.teamManagers, [ 'order', parseInt(this.$store.getters.currentBidManagerIndex) ]));
            }
        },
        computed: {
            isCloseAuction() {
                return this.$store.getters.isCloseAuction
            },
            currentBidManagerData() {
                let manager = _.head(_.filter(this.$store.getters.teamManagers, [ 'order', parseInt(this.$store.getters.currentBidManagerIndex) ]))
                return manager;
            }
        },
        mounted() {
        },
        methods: {
            back() {
            },
            showBidEditForm(event) {
            	let currentPlayer = this.$store.getters.soldPlayers;
            	this.showEditPlayerBidForm = event[0];
            	this.player = _.head(_.filter(currentPlayer, [ 'player_id', parseInt(event[1]) ]));
            },
            showTeamPlayers(event) {
                this.currentTeamID = event
                this.showTeamList = false
            }
        }
	};
</script>