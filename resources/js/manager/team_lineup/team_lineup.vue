<template>

    <div class="row no-gutters">

        <div class="col-lg-12" v-if="!supersubFeatureLive">
            <div class="custom-alert alert-tertiary mt-3">
                <div class="alert-icon">
                    <img src="/assets/frontend/img/cta/icon-whistle.svg" alt="alert-img">
                </div>
                <div class="alert-text text-dark">
		    SUPERSUBS has been disabled this weekend due to unforeseen issues, but you can set your starting lineup via the SUBS tab.  We advise you front-load your players for the 12:30 and 15:00 kick-offs and then may only need one more set of substitutions after 15:00 for 17:30 and Sunday games. Apologies for any inconvenience caused.
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="js-left-pitch-area">
            	<div id="lineUp-Details" class="squad-Details">
                    <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary m-0" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="Squad-tab" data-toggle="pill" href="#Squad" role="tab" aria-controls="Squad" aria-selected="true" @click="tabClicked('squad')">Squad</a>
                        </li>
                        <li class="nav-item" v-if="allowWeekendSwap && ownTeam">
                            <a class="nav-link" id="Subs-tab" data-toggle="pill" href="#Subs" role="tab" aria-controls="Subs" aria-selected="false" @click="tabClicked('sub')">Subs</a>
                        </li>
                        <li class="nav-item" v-if="(supersubFeatureLive) && ((enableSupersubs && allowWeekendChanges) && (ownTeam && isSupersubDisabled))">
                            <a class="nav-link" id="Supersubs-tab" data-toggle="pill" href="#Supersubs" role="tab" aria-controls="Supersubs" aria-selected="false" @click="supersubsClicked">Supersubs</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="Squad" role="tabpanel" aria-labelledby="Squad-tab">
                        <squad :active-players='activePlayersData' :sub-players='activeSubPlayersData' :team='team' :pitch-url='pitchUrl' :teamStats='teamStats' :seasons="seasons" :current-season="currentSeason" :playerSeasonStats="playerSeasonStats" @displaySquadPlayerDetails='displaySquadPlayerDetails' :teamPlayerStatDetails="teamPlayerStatDetails" @changeCurrentTab="currentTab = $event"></squad>
                    </div>
                    <div class="tab-pane fade" id="Subs" role="tabpanel" aria-labelledby="Subs-tab" v-if="allowWeekendSwap && ownTeam">
                        <subs :active-players='activePlayersData' :sub-players='activeSubPlayersData' :division="division" :team='team' :pitch-url='pitchUrl' :available-formations="availableFormations" :possible-positions="possiblePositions" @displaySquadPlayerDetails='displaySquadPlayerDetails' :teamPlayerStatDetails="teamPlayerStatDetails" :allowWeekendSwap="allowWeekendSwap" @updateSuperSubsData='updateSuperSubsData' @updateClearSupersubDataFlag='updateClearSupersubDataFlag' :currentTab="currentTab" @updatePlayersSquadData='updatePlayersSquadData'></subs>
                    </div>

                    <div class="tab-pane fade" id="Supersubs" role="tabpanel" aria-labelledby="Supersubs-tab" v-if="(supersubFeatureLive) && ((enableSupersubs && allowWeekendChanges) && (ownTeam && allowWeekendSwap))">
                        <supersubs @setDateFlag="setDateFlag" :active-players='activePlayersSuperSubData' :sub-players='subPlayersSuperSubData' :parent-active-players='activePlayers' :parent-sub-players='subPlayers' :division="division" :team='team' :pitch-url='pitchUrl' :available-formations="availableFormations" :possible-positions="possiblePositions" :team-clubs=" teamClubs " :future-fixtures-dates=" futureFixturesDates " :teamPlayerStatDetails="teamPlayerStatDetails" :clearSupersubData="clearSupersubData" :currentTab="currentTab" :superSubFixtureDates="superSubFixtureDatesForSuperSub"></supersubs>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="player-data scrollbar">
                <div class="data-container-area">
                    <div class="player-data-container">

                        <div v-show="displayTeamStats && (!mobileScreen || (mobileScreen && selectedTab == 'squad'))">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary m-0 p-2 bg-dark border-0 rounded-0" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-player-tab" data-toggle="pill" href="#pills-player" role="tab" aria-controls="pills-player" aria-selected="true">Players</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-history-tab" data-toggle="pill" href="#pills-history" role="tab" aria-controls="pills-history" aria-selected="false">History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-sold-tab" data-toggle="pill" href="#pills-sold" role="tab" aria-controls="pills-sold" aria-selected="false">Sold</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-player" role="tabpanel" aria-labelledby="pills-player-tab">
                                    <squadstats :active-players="activePlayersSquadData" :sub-players="activeSubPlayersSquadData" :player-season-stats="playerSeasonStats" @displaySquadPlayerDetails='displaySquadPlayerDetails' :currentTab="currentTab" :division="division" :team="team" :columns="columns"></squadstats>
                                </div>
                                <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">

                                    <historystats :player-history="playerHistory" :sold-player-ids="soldPlayerIds" :columns="columns" @displaySquadPlayerDetails='displaySquadPlayerDetails' :currentTab="currentTab"></historystats>

                                </div>
                                <div class="tab-pane fade" id="pills-sold" role="tabpanel" aria-labelledby="pills-sold-tab">

                                    <soldstats :sold-player="soldPlayer" :columns="columns" @displaySquadPlayerDetails='displaySquadPlayerDetails' :currentTab="currentTab"></soldstats>
                                </div>
                            </div>
                        </div>

                        <template v-if="!mobileScreen">
                            <playerstats v-if="!displayTeamStats" :player="selectedSquadPlayerStats" @hideSquadPlayerDetails="displayTeamStats = true" :seasons="seasons" :current-season="selectedSeason" :team="team" :division="division" @displayPlayerStats="displayPlayerStats"></playerstats>
                        </template>

                        <div v-if="mobileScreen" class="player-info-modal" id="players-info" tabindex="-1" role="dialog" aria-labelledby="players-info" aria-hidden="true">
                            <div class="modal-card" role="document">
                                <div class="modal-card-head">
                                    <div class="header">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                    <ul class="top-navigation-bar">
                                                        <li>
                                                            <a href="javascript:void(0);" data-dismiss="modal" aria-label="Close" @click="displayTeamStats = true">
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
                                    <playerstats :player="selectedSquadPlayerStats" @hideSquadPlayerDetails="displayTeamStats = true" :seasons="seasons" :current-season="selectedSeason" :team="team" :division="division" @displayPlayerStats="displayPlayerStats"></playerstats>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="supersubGuide" tabindex="-1" role="dialog" aria-labelledby="fixtureModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered lineup-modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-dark font-weight-bold mb-4">Supersubs Guide</h6>
                        <p>Click on a fixture time above the pitch to see players active in matches at that fixture time highlighted in green. Where possible, your active players are automatically placed into your team but need to be saved for each fixture time. You can make changes by clicking on relevant player(s) and to accept changes hit ACCEPT AND SAVE. To cancel changes for that block of fixtures hit CANCEL.</p>

                        <p>The dates where you have an unsaved line-up are highlighted in orange, whilst the dates where your line-up is saved are highlighted in white.</p>

                        <p>The ticks / crosses shown on the last column of the right-hand list view show whether a player has been selected against the listed match. Hit refresh to make sure this shows the latest information.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import squad from './team_players/index.vue';
import subs from './team_players_swap/index.vue';
import supersubs from './supersubs/index.vue';
import squadstats from './team_players/squad_stats.vue';
import historystats from './team_players/history.vue';
import soldstats from './team_players/sold.vue';
import playerstats from './team_players/components/player/stats.vue';
import { EventBus } from './supersubs/event-bus.js';
import { EventBus1 } from './event-bus1.js';

export default {
    components: {
        squad, subs, supersubs, squadstats, playerstats,historystats, soldstats
    },

    props: ['activePlayers', 'subPlayers','pitchUrl', 'division', 'team', 'availableFormations', 'possiblePositions', 'teamClubs', 'futureFixturesDates', 'teamStats', 'seasons', 'currentSeason', 'playerSeasonStats', 'ownTeam', 'allowWeekendSwap', 'isSupersubDisabled', 'enableSupersubs', 'allowWeekendChanges','supersubFeatureLive','superSubFixtureDates', 'columns'],
    data() {
        return {
            selectedSeason: this.currentSeason,
            activePlayersData: [],
            activeSubPlayersData: [],
            activePlayersSquadData: [],
            parentActivePlayersData: [],
            parentActiveSubPlayersData: [],
            activeSubPlayersSquadData: [],
            teamSquadPlayerStatDetails: [],
            activePlayersSuperSubData: [],
            selectedSquadPlayerStats:[],
            subPlayersSuperSubData: [],
            displayTeamStats: true,
            mobileScreen: false,
            teamPlayerStatDetails: [],
            selectedTab: 'squad',
            clearSupersubData: false,
            lineupSelectedTab: 'current_week',
            currentTab: 'current_week',
            currentSelectedPlayer: 0,
            superSubFixtureDatesForSuperSub: [],
            isDataLoad: true,
            playerHistory: {},
            soldPlayer: {},
            soldPlayerIds: [],
        };
    },
    mounted() {

        EventBus.$on('updatePlayersData', player => {
            this.activePlayersData = _.cloneDeep(player[0]);
            this.activeSubPlayersData = _.cloneDeep(player[1]);

            this.activePlayersSquadData = _.cloneDeep(player[0]);
            this.activeSubPlayersSquadData = _.cloneDeep(player[1]);
        });

        EventBus.$on('updatePlayersSquadData', player => {
            this.activePlayersSquadData = _.cloneDeep(player[0]);
            this.activeSubPlayersSquadData = _.cloneDeep(player[1]);
        });

        EventBus.$on('updateSuperSubFixturesData', fixtures => {
            this.superSubFixtureDatesForSuperSub = fixtures;
        });

        EventBus.$on('showCurrentPlayerStats', player => {
            this.displaySquadPlayerDetails(player);
        });

        EventBus.$on('updateSuperSubsData', player => {
            this.updateSuperSubsData(player);
        });

        EventBus1.$on('checkTeamPlayersSelectedTab', tab => {
            this.lineupSelectedTab = tab;
            this.changeSelectedTab();
        });

        this.getSquadPlayerStats();
        this.getHistoryPlayers();
    },
    created() {
        this.parentActivePlayersData = _.cloneDeep(this.activePlayers);
        this.parentActiveSubPlayersData = _.cloneDeep(this.subPlayers);

        this.activePlayersData = _.cloneDeep(this.activePlayers);
        this.activeSubPlayersData = _.cloneDeep(this.subPlayers);

        this.activePlayersSquadData = _.cloneDeep(this.activePlayers);
        this.activeSubPlayersSquadData = _.cloneDeep(this.subPlayers);

        this.activePlayersSuperSubData = _.cloneDeep(this.activePlayers);
        this.subPlayersSuperSubData = _.cloneDeep(this.subPlayers);

        this.superSubFixtureDatesForSuperSub = _.cloneDeep(this.superSubFixtureDates);

        var vm = this;
        setTimeout(function() {
            let supersubActive = window.location.search.replace('?', '').split('&').includes('supersub=true')
            if(supersubActive) {
                $('#Supersubs-tab').trigger('click');
                vm.supersubsClicked();
            }
        })
    },
    methods: {
        tabClicked: function(tab) {
            this.selectedTab = tab;
            // this.activePlayersSquadData = _.cloneDeep(this.parentActivePlayersData);
            // this.activeSubPlayersSquadData = _.cloneDeep(this.parentActiveSubPlayersData);
            this.getSwapFixtures();
        },
        getHistoryPlayers() {
            let vm = this;
            vm.axios.get(route('team.lineup.history.players', {division: vm.division,team: vm.team,}))
                .then(response => {
                    vm.playerHistory = response.data.playerHistory;
                    vm.getSoldPlayers();
                })
                .catch(e => {
                  console.log('Fetching error in history players');
                  vm.getSoldPlayers();
                })
        },
        getSoldPlayers() {
            let vm = this;
            vm.axios.get(route('team.lineup.sold.players', {division: vm.division,team: vm.team,}))
                .then(response => {
                    vm.soldPlayer = response.data.soldPlayer;
                    vm.soldPlayerIds = response.data.soldPlayerIds;
                })
                .catch(e => {
                  console.log('Fetching error in sold players');
                })
        },
        getSwapFixtures() {
            let vm = this;
            if(!vm.isDataLoad) {
                vm.axios.post(route('manage.team.fixture.players.swap', {division: vm.division,team: vm.team,}), {})
                .then((response) => {
                    vm.activePlayersSquadData = _.cloneDeep(response.data.activePlayers);
                    vm.activeSubPlayersSquadData = _.cloneDeep(response.data.subPlayers);
                    vm.isDataLoad = true;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        setDateFlag: function(date) {
            let elementId = 'js-' + date.replace(/[-:\s]/gi, '')
            $('.' + elementId).addClass('modified-content');
        },
        supersubsClicked: function() {
            this.isDataLoad = false;
            var index = 0;
            $('div.schedule-supersub a').each(function(k, v) {
                if($(this).hasClass('is-active')) {
                    index = k;
                }
            })

            this.selectedTab = 'supersub'
            this.axios.get(route('manage.supersub.guide.counter'))
                .then((response) => {
                    if(response.data) {
                        $('#supersubGuide').modal('show');
                    }
                })
                .catch((error) => {
                    console.log(error);
                });

            var selectedFixtureDate = _.keys(this.futureFixturesDates)[index];
            EventBus.$emit('updateSelectedFixture', selectedFixtureDate);
        },
        updateSuperSubsData: function(player) {
            this.activePlayersSuperSubData = _.cloneDeep(player[0]);
            this.subPlayersSuperSubData = _.cloneDeep(player[1]);
            EventBus.$emit('updateSupersubTempData');
        },
        updatePlayersSquadData: function(players) {
            this.activePlayersSquadData = _.cloneDeep(players[0]);
            this.activeSubPlayersSquadData = _.cloneDeep(players[1]);
        },
        updateClearSupersubDataFlag: function() {
            this.clearSupersubData = true;
        },
        displayPlayerStats: function(playerStats) {
            this.selectedSquadPlayerStats = playerStats[0];
            this.selectedSeason = playerStats[1];
        },
        getSquadPlayerStats: function() {
            this.axios.get(route('manage.team.player.stats', {division: this.division, team: this.team}))
                .then((response) => {

                    this.teamSquadPlayerStatDetails = response.data;
                    this.getSquadPlayerStatsSold();
                    
                    if(this.isMobileScreen()) {
                        this.mobileScreen = true;
                    }

                })
                .catch((error) => {
                    this.getSquadPlayerStatsSold();
                    console.log(error);
                });
        },
        getSquadPlayerStatsSold: function() {
            this.axios.get(route('manage.team.player.stats.sold', {division: this.division, team: this.team}))
                .then((response) => {
                    this.teamSquadPlayerStatDetails = _.merge(this.teamSquadPlayerStatDetails, response.data);
                    this.selectedSquadPlayerStats = this.teamSquadPlayerStatDetails[this.currentSelectedPlayer];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        displaySquadPlayerDetails(player_id) {
            this.currentSelectedPlayer = player_id;
            this.selectedSeason = this.currentSeason;
            if(typeof(this.teamSquadPlayerStatDetails[player_id]) != "undefined") {
                this.selectedSquadPlayerStats = this.teamSquadPlayerStatDetails[player_id];
            } else {
                this.selectedSquadPlayerStats = [];
            }
            this.displayTeamStats = false;
            if(this.isMobileScreen()) {
                this.mobileScreen = true;
                setTimeout(function(){
                    $('#players-info').modal('show');
                }, 10);
            } else {
                this.displayTeamStats = false;
                this.changeSelectedTab();
                this.slimScroll();
            }

            setTimeout(function(){
                $('#season-archive-selectbox option:last').prop("selected", "selected");
            }, 10);

            $("#History-tab").trigger("click");
        },
        changeSelectedTab() {
            // this.$nextTick(() => {
            //     EventBus1.$emit('changeTab', this.lineupSelectedTab);
            // });
        }
    }
}
</script>
