<template>
	<div class="standing-view-grid gutters-tiny">
        <div class="standing-col">
            <player :player="activePlayers.gk[0]" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayerData" :popupOpened="popupOpened" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :selectedPlayerIndex="0" :isPlayerMoveable="isPlayerMoveable" :minMaxNumberForPosition="minMaxNumberForPosition" :groupCount="1" :activePlayers="activePlayers" :selectedFixtureDate="selectedFixtureDate" :activeClubPlayers="activeClubPlayers" :currentTab="currentTab" :checkFirstFixture="checkFirstFixture"></player>
        </div>
    </div>
</template>

<script>

import player from '../../components/player/index.vue';

export default {
    components: {
        player
    },
    props: ['activePlayers', 'currActivePlayer', 'playerSelected', 'selectedPlayerData', 'popupOpened', 'selectedPlayer', 'selectedSubPlayer', 'isPlayerMoveable', 'minMaxNumberForPosition', 'selectedFixtureDate', 'activeClubPlayers', 'currentTab', 'checkFirstFixture'],
    data() {
        return {

        };
    },
    computed: {
    },
    mounted() {
    },
    methods: {
        setPlayerData: function(event) {
            this.$emit('setCurrentPlayerId', event);
        }
    }
}
</script>
