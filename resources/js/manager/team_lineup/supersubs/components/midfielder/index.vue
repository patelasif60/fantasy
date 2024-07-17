<template>
	<div class="standing-view-grid gutters-tiny">
        <div class="standing-col" v-for="(player, index) in activePlayers.mf">
            <player :player="player" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayerData" :popupOpened="popupOpened" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :selectedPlayerIndex="index" :isPlayerMoveable="isPlayerMoveable" :minMaxNumberForPosition="minMaxNumberForPosition" :groupCount="activePlayers.mf.length" :activePlayers="activePlayers" :selectedFixtureDate="selectedFixtureDate" :activeClubPlayers="activeClubPlayers" :currentTab="currentTab" :checkFirstFixture="checkFirstFixture"></player>
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
    watch: {
    },
    mounted() {

    },
    methods: {

    }
}
</script>
