<template>
	<div class="standing-view-grid gutters-tiny">
        <div class="standing-col" v-for="(player, key) in activePlayers.st">
            <player :player="player" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayerData" :popupOpened="popupOpened" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :selectedPlayerIndex="key" :isPlayerMoveable="isPlayerMoveable" :minMaxNumberForPosition="minMaxNumberForPosition" :groupCount="activePlayers.st.length" :activePlayers="activePlayers" :selectedFixtureDate="selectedFixtureDate" :activeClubPlayers="activeClubPlayers" :currentTab="currentTab" :checkFirstFixture="checkFirstFixture"></player>
        </div>
    </div>
</template>

<script>

import player from '../../components/player/index.vue';

export default {
    components: {
        player
    },
    props: ['activePlayers', 'currActivePlayer', 'playerSelected', 'selectedPlayerData', 'popupOpened', 'selectedPlayer', 'selectedSubPlayer','isPlayerMoveable', 'minMaxNumberForPosition', 'selectedFixtureDate', 'activeClubPlayers', 'currentTab', 'checkFirstFixture'],
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
