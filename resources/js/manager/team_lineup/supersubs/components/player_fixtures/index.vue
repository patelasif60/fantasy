<template>
	<div class="player-data-container">
        <div class="player-data-container-slim">
            <div class="row no-gutters">
                <div class="table-responsive">
                	
                	<activeplayersfixtures :active-players="activePlayers" @displayPlayerDetails='displayPlayerDetails'></activeplayersfixtures>

                	<subplayersfixtures :sub-players="subPlayers" @displayPlayerDetails='displayPlayerDetails'></subplayersfixtures>
                
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
    props: ['activePlayers', 'subPlayers'],
    data() {
        return {
            
        };
    },
    computed: {
    },
    mounted() {
        
    },
    methods: {    
        displayPlayerDetails(player_id) {
            this.$emit('displayPlayerDetails', player_id);
        }
    }
}
</script>