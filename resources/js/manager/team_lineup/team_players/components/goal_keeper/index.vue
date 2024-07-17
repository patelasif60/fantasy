<template>
	<div class="standing-view-grid gutters-tiny">
        <div class="standing-col">
            <player :player="activePlayers.gk[0]" :selectedPlayerId="selectedPlayerId" :currentTab="currentTab" @displayPlayerStat="$emit('displayPlayerStat', $event)"></player>
        </div>
    </div>
</template>

<script>

import player from '../../components/player/index.vue';

export default {
    components: {
        player
    },
    props: ['activePlayers', 'selectedPlayerId', 'playerPointsStats', 'currentTab'],
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
