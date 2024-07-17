<template>
	<div class="standing-view-grid gutters-tiny">
        <div class="standing-col" v-for="(player, key) in activePlayers.st">
            <player :player="player" :selectedPlayerId="selectedPlayerId" :currentTab="currentTab" @displayPlayerStat="$emit('displayPlayerStat', $event)"></player>
        </div>
    </div>
</template>

<script>

import player from '../../components/player/index.vue';

export default {
    components: {
        player
    },
    props: ['activePlayers', 'selectedPlayerId', 'currentTab'],
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
