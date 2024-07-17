<template>
    
    <div class="col-12">
        <div class="container-wrapper">
            <div class="container-body">
                <div class="row mt-1 text-white">
                    <div class="col-12">

                        <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="team-tab" data-toggle="pill" href="#team" role="tab" aria-controls="team" aria-selected="true">Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="player-tab" data-toggle="pill" href="#player" role="tab" aria-controls="player" aria-selected="false">Players</a>
                            </li>
                        </ul>

                         <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="team" role="tabpanel" aria-labelledby="team-tab">

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
    
</template>

<script>

    import teamList from "../auctiontioneer/teamlist.vue";
    import teamPlayers from "../auctiontioneer/teamplayers.vue";
    import allPlayers from "../auctiontioneer/all_players.vue";

    export default {
        components: { teamList, teamPlayers, allPlayers },
        props: [ 'clubs', 'positions', 'players', 'division', 'teamDetails' ],
		data() {
			return {
                showTeamList: true,
                currentTeamID: 0,
			}
		},
        created() {
            
        },
        mounted() {
        },
        methods: {
            showTeamPlayers(event) {
                this.currentTeamID = event
                this.showTeamList = false
            }
        }
	};
</script>