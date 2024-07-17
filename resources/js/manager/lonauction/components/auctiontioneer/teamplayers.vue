<template>
	<div>

		<div class="row">
			<div class="col-12">
				<p @click="$emit('showTeamList', true)" class="cursor-pointer small"><i class="fas fa-chevron-left mr-2"></i>Back</p>	
			</div>
		</div>
		
		<div class="js-left-pitch-area js-player-out">
            <div class="pitch-layout live-auction">
                <div class="pitch-area">
                    <div class="pitch-image">
                        <img class="lazyload" src="/assets/frontend/img/pitch/pitch-1.svg" data-src="/assets/frontend/img/pitch/pitch-1.svg" alt="">
                    </div>
                    <div class="pitch-players-standing">
                        <div class="pitch-player-position-wrapper h-100">
                            <div class="player-position-view js-player-view">
                                
                                <div class="player-position-grid gutters-tiny has-player">
                                    <div class="position-wrapper">
                                        <div class="position-action-area">
                                            <div>
                                                <span class="standing-view-player-position is-gk position-relative">GK</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="player-position-col" v-for="player in players['gk']" v-if="typeof players['gk'] != 'undefined'">
							            <div class="player-wrapper auction-player-wrapper">
							                <player :player="player"></player>
							            </div>
							        </div>
                                </div>

                                <div class="player-position-grid gutters-tiny has-player">
                                    <div class="position-wrapper">
                                        <div class="position-action-area">
                                            <div>
                                                <span class="standing-view-player-position is-fb position-relative">FB</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="player-position-col" v-for="player in players['fb']" v-if="typeof players['fb'] != 'undefined'">
							            <div class="player-wrapper auction-player-wrapper">
							                <player :player="player"></player>
							            </div>
							        </div>
                                </div>

                                <div class="player-position-grid gutters-tiny has-player">
                                    <div class="position-wrapper">
                                        <div class="position-action-area">
                                            <div>
                                                <span class="standing-view-player-position is-cb position-relative">CB</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="player-position-col" v-for="player in players['cb']" v-if="typeof players['cb'] != 'undefined'">
							            <div class="player-wrapper auction-player-wrapper">
							                <player :player="player"></player>
							            </div>
							        </div>
                                </div>


                                <div class="player-position-grid gutters-tiny has-player">
                                    <div class="position-wrapper">
                                        <div class="position-action-area">
                                            <div>
                                                <span class="standing-view-player-position is-mf position-relative">MF</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="player-position-col" v-for="player in players['mf']" v-if="typeof players['mf'] != 'undefined'">
							            <div class="player-wrapper auction-player-wrapper">
							                <player :player="player"></player>
							            </div>
							        </div>
                                </div>

                                <div class="player-position-grid gutters-tiny has-player">
                                    <div class="position-wrapper">
                                        <div class="position-action-area">
                                            <div>
                                                <span class="standing-view-player-position is-st position-relative">ST</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="player-position-col" v-for="player in players['st']" v-if="typeof players['st'] != 'undefined'">
							            <div class="player-wrapper auction-player-wrapper">
							                <player :player="player"></player>
							            </div>
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
	import player from "./player.vue";
	export default {
		prop: ['currentTeamID'],
		components: {
			player
		},
		data() {
			return {
                players: []
			}
		},
		computed: {
			teamPlayers() {

			}
		},
		mounted() {
			let divId = this.$store.getters.getDivisionId;
            axios.get(route('manage.lonauction.team.sold.player', {'division': divId, 'team': this.$attrs.currentTeamID}))
                .then((response) => {
                    this.players = response.data;
                })
                .catch((error) => {
                    console.log(error)
                });
		}
	}
</script>