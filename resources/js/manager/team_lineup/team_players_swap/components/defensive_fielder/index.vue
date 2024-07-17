<template>
	<div class="standing-view-grid gutters-tiny">
        <div class="standing-col" v-for="(player, index) in activePlayers.df">
            <player :player="player" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayerData" :popupOpened="popupOpened" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :selectedPlayerIndex="index" :isPlayerMoveable="isPlayerMoveable" :minMaxNumberForPosition="minMaxNumberForPosition" :groupCount="activePlayers.df.length" :activePlayers="activePlayers" :allowWeekendSwap="allowWeekendSwap" :currentTab="currentTab"></player>
        </div>
    </div>
</template>

<script>

import player from '../../components/player/index.vue';

export default {
    components: {
        player
    },
    props: ['activePlayers', 'currActivePlayer', 'playerSelected', 'selectedPlayerData', 'popupOpened', 'selectedPlayer', 'selectedSubPlayer', 'isPlayerMoveable', 'minMaxNumberForPosition', 'allowWeekendSwap', 'currentTab'],
    data() {
        return {
            // dflength: this.df.length
        };
    },
    computed: {
    },
    mounted() {
    },
    methods: {
        // updatePlayercount () {
        //     this.dflength = this.df.length
        // },
    }
}
</script>
