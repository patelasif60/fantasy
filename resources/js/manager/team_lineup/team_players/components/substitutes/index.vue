<template>
	<div class="player-data-wrapper">
        <div class="player-data-title">
            Substitutes
        </div>
        <div class="players-list" v-if="subPlayers.length">
            <div class="players-list-wrapper" v-for="(subplayer, index) in subPlayers">
                <subplayer :player="subplayer" :selectedPlayerId="selectedPlayerId" :current-tab="currentTab"></subplayer>
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
    props: ['subPlayers', 'selectedPlayerId', 'currentTab'],
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