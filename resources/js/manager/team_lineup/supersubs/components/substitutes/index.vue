<template>
	<div class="player-data-wrapper">
        <div class="player-data-title">
            Substitutes
        </div>
        <div class="players-list" v-if="subPlayers.length">
            <div class="players-list-wrapper" v-for="(subplayer, index) in subPlayers">
                <subplayer :player="subplayer" :currActiveSubPlayer="currActiveSubPlayer" :subPlayerSelected="subPlayerSelected" :selectedPlayerData="selectedPlayerData" :popupOpened="popupOpened" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :playerIndex="index" :minMaxNumberForPosition="minMaxNumberForPosition" :activePlayers="activePlayers" :placement="placement" :selectedFixtureDate="selectedFixtureDate" :activeClubPlayers="activeClubPlayers"></subplayer>
                 <!-- :dfCount="activePlayers['df'].length" :mfCount="activePlayers['mf'].length" :stCount="activePlayers['st'].length" -->
            </div>
        </div>
    </div>
</template>

<script>

import subplayer from '../../components/sub_player/index.vue';

export default {
    components: {
        subplayer
    },
    props: ['activePlayers', 'subPlayers', 'currActiveSubPlayer', 'subPlayerSelected', 'selectedPlayerData', 'popupOpened', 'selectedPlayer', 'selectedSubPlayer', 'minMaxNumberForPosition', 'placement', 'selectedFixtureDate', 'activeClubPlayers'],
    data() {
        return {
            
        };
    },
    computed: {
    },
    mounted() {
        
    },
    methods: {    
        
    }
}
</script>