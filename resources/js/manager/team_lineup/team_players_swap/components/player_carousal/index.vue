<template>
    <div class="player-data-carousel">
        <div class="owl-carousel owl-theme player-carousel" v-if="subPlayers.length">
            <div class="item" v-for="(subplayer, index) in subPlayers">
                <subplayer :player="subplayer" :currActiveSubPlayer="currActiveSubPlayer" :subPlayerSelected="subPlayerSelected" :selectedPlayerData="selectedPlayerData" :popupOpened="popupOpened" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :playerIndex="index" :minMaxNumberForPosition="minMaxNumberForPosition" :activePlayers="activePlayers" :placement="placement" :allowWeekendSwap="allowWeekendSwap" :currentTab="currentTab"></subplayer>
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
    props: ['activePlayers', 'subPlayers', 'currActiveSubPlayer', 'subPlayerSelected', 'selectedPlayerData', 'popupOpened', 'selectedPlayer', 'selectedSubPlayer', 'minMaxNumberForPosition', 'placement', 'allowWeekendSwap', 'currentTab'],
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
