<template>
	<div class="player-data-container">
        <div class="player-data-container-slim">
            <div class="row no-gutters">
                <div class="table-responsive">
                	
                	<activeplayersfixtures :active-players="activePlayers" @displaySquadPlayerDetails='displaySquadPlayerDetails' :playerSeasonStats="playerSeasonStats"></activeplayersfixtures>

                	<subplayersfixtures :sub-players="subPlayers" @displaySquadPlayerDetails='displaySquadPlayerDetails' :playerSeasonStats="playerSeasonStats"></subplayersfixtures>
                
                 </div>
            </div>
        </div>
    </div>
</template>

<script>

import activeplayersfixtures from './active_players_fixtures/index.vue';
import subplayersfixtures from './sub_players_fixtures/index.vue';

export default {
    components: {
        activeplayersfixtures, subplayersfixtures
    },
    props: ['activePlayers', 'subPlayers', 'playerSeasonStats'],
    data() {
        return {
            
        };
    },
    computed: {
    },
    mounted() {
        
    },
    methods: {    
        displaySquadPlayerDetails(player_id) {
            this.$emit('displaySquadPlayerDetails', player_id);
        }
    }
}
</script>