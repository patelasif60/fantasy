<template>
    <div v-cloak>

        <div class="text-center inner-tab py-1">
            <ul class="nav nav-pills theme-tabs theme-tabs-dark m-0 d-inline-flex border-0" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="week-tab" data-toggle="pill" href="javascript:void(0)" role="tab" aria-controls="week" aria-selected="true" @click="changeCurrentTab('current_week')">WEEK {{teamStats.current_week}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="total-tab" data-toggle="pill" href="#total" role="tab" aria-controls="total" aria-selected="false" @click="changeCurrentTab('week_total')">TOTAL {{teamStats.week_total}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="fa-cup-round-tab" data-toggle="pill" href="#fa-cup-round" role="tab" aria-controls="fa-cup-round" aria-selected="false" @click="changeCurrentTab('facup_prev')">FA CUP ROUND {{teamStats.facup_prev}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="fa-cup-total-tab" data-toggle="pill" href="#fa-cup-total" role="tab" aria-controls="fa-cup-total" aria-selected="false" @click="changeCurrentTab('facup_total')">FA CUP TOTAL {{teamStats.facup_total}}</a>
                </li>
            </ul>
        </div>

        <div class="pitch-layout">
            <div class="pitch-area">
                <pitch :pitch-url="pitchUrl"></pitch>
                <div class="pitch-players-standing">
                    <div class="standing-area">
                        <div class="standing-view">
                            <goalkeeper :activePlayers="activeSquadPlayers" :selectedPlayerId="selectedPlayerId" :currentTab="currentTab" @displayPlayerStat="$emit('displaySquadPlayerDetails',$event)"></goalkeeper>
                            <defensivefielder :activePlayers="activeSquadPlayers" :selectedPlayerId="selectedPlayerId" :currentTab="currentTab" @displayPlayerStat="$emit('displaySquadPlayerDetails',$event)"></defensivefielder>
                            <midfielder :activePlayers="activeSquadPlayers" :selectedPlayerId="selectedPlayerId" :currentTab="currentTab" @displayPlayerStat="$emit('displaySquadPlayerDetails',$event)"></midfielder>
                            <striker :activePlayers="activeSquadPlayers" :selectedPlayerId="selectedPlayerId" :currentTab="currentTab" @displayPlayerStat="$emit('displaySquadPlayerDetails',$event)"></striker>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fixed-bottom-content">
                <playercarousal :sub-players="subSquadPlayer" :currentTab="currentTab" @displayPlayerStat="$emit('displaySquadPlayerDetails',$event)"></playercarousal>
            </div>

            <!-- <div class="player-data" v-if="!isMobileScreen()">
                <div class="data-container-area">
                    <substitutes :sub-players="subSquadPlayer" :selectedPlayerId="selectedPlayerId" :current-tab="currentTab"></substitutes>

                    <fixtures v-show="displayTeamStats" :active-players="activeSquadPlayers" :sub-players="subSquadPlayer" :playerSeasonStats="playerSeasonStats" @displaySquadPlayerDetails='displaySquadPlayerDetails'></fixtures>

                    <playerstats v-if="!displayTeamStats" :player="selectedSquadPlayerStats" @hideSquadPlayerDetails="hideSquadPlayerDetails" :seasons="seasons" :current-season="currentSeason" :team="team"></playerstats>
                </div>
            </div> -->
            
            <!-- <div v-if="mobileScreen" class="player-info-modal" id="players-info" tabindex="-1" role="dialog" aria-labelledby="players-info" aria-hidden="true">
                <div class="modal-card" role="document">
                    <div class="modal-card-head">
                        <div class="header">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="top-navigation-bar">
                                            <li>
                                                <a href="javascript:void(0);" data-dismiss="modal" aria-label="Close">
                                                    <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                                                </a>
                                            </li>
                                            <li class="text-center has-dropdown has-arrow">
                                                Player Detail
                                            </li>
                                            <li class="text-right">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-card-body">
                        <playerstats v-if="mobileScreen" :player="selectedSquadPlayerStats" @hideSquadPlayerDetails="hideSquadPlayerDetails" :seasons="seasons" :current-season="currentSeason" :team="team"></playerstats>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>

import pitch from './components/pitch/index.vue';
import goalkeeper from './components/goal_keeper/index.vue';
import defensivefielder from './components/defensive_fielder/index.vue';
import midfielder from './components/midfielder/index.vue';
import striker from './components/striker/index.vue';
import substitutes from './components/substitutes/index.vue';
import fixtures from './components/player_fixtures/index.vue';
import playercarousal from './components/player_carousal/index.vue';
// import playerstats from './components/player/stats.vue';

import { EventBus } from './event-bus.js';
import { EventBus1 } from '../event-bus1.js';


export default {
    components: {
        pitch, goalkeeper, defensivefielder, midfielder, striker, substitutes, fixtures, playercarousal
    },
    props: ['activePlayers', 'subPlayers','pitchUrl', 'team', 'teamStats', 'seasons', 'currentSeason', 'playerSeasonStats', 'teamPlayerStatDetails'],
    data() {
        return {
            teamSquadPlayerStatDetails: [],
            selectedSquadPlayerStats:[],
            displayTeamStats: true,
            selectedPlayerId: 0,
            activeSquadPlayers: this.activePlayers,
            subSquadPlayer: this.subPlayers,
            currentTab: "current_week",
        };
    },
    computed: {
    },
    created() {
    },
    watch: {
      activePlayers: {
        handler: function (someData) {
          // check someData and eventually call
          this.activeSquadPlayers = this.activePlayers;
        },
        immediate: true
      },
      subPlayers: {
        handler: function (someData) {
          // check someData and eventually call
          this.subSquadPlayer = this.subPlayers;
        },
        immediate: true
      }
    },
    mounted() {
        EventBus.$on('setCurrentPlayerStats', player => {
            this.selectedSquadPlayerStats = player;
        });
    },
    methods: {
        changeCurrentTab(currentTab)
        {
            this.currentTab = currentTab;
            EventBus1.$emit('checkTeamPlayersSelectedTab', currentTab);
            this.$emit('changeCurrentTab', currentTab);
        }
    }
}
</script>
