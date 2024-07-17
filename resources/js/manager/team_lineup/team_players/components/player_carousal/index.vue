<template>
    <div class="player-data-carousel">
        <div class="owl-carousel owl-theme player-carousel" v-if="subPlayers.length">
            <div class="item" v-for="(subplayer, index) in subPlayers">
                <subplayer :player="subplayer" :currentTab="currentTab" @displayPlayerStat="$emit('displayPlayerStat', $event)"></subplayer>
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
    props: ['subPlayers', 'currentTab'],
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