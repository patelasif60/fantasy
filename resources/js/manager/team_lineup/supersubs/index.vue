<template>
    <div v-cloak>

        <fixturedatescarousal :futureFixturesDates="futureFixturesDates" :superSubSelectedDate="superSubSelectedDate" :superSubFixtureDates="superSubFixtureDates"></fixturedatescarousal>

        <div class="display-date-time">
            <a href="javascript:void(0)" @click="openFixturesModal" class="text-dark link-nostyle" v-if="selectedFixtureDisplay">
                {{ selectedFixtureDisplay | moment("dddd Do MMMM YYYY - HH:mm") }}
            </a>
        </div>

        <div class="pitch-layout">
            <div class="pitch-area">
                <pitch :pitch-url="pitchUrl"></pitch>
                <div class="pitch-players-standing">
                    <div class="standing-area">
                        <div class="standing-view">
                            <goalkeeper :activePlayers="activePlayers" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :selectedFixtureDate="selectedFixture" :activeClubPlayers="activeClubPlayers" :isPlayerMoveable="canSwapPlayers" :currentTab="currentTab" :checkFirstFixture="checkFirstFixture"></goalkeeper>
                            <defensivefielder :activePlayers="activePlayers" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :selectedFixtureDate="selectedFixture" :activeClubPlayers="activeClubPlayers" :isPlayerMoveable="canSwapPlayers" :currentTab="currentTab" :checkFirstFixture="checkFirstFixture"></defensivefielder>
                            <midfielder :activePlayers="activePlayers" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :selectedFixtureDate="selectedFixture" :activeClubPlayers="activeClubPlayers" :isPlayerMoveable="canSwapPlayers" :currentTab="currentTab" :checkFirstFixture="checkFirstFixture"></midfielder>
                            <striker :activePlayers="activePlayers" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :selectedFixtureDate="selectedFixture" :activeClubPlayers="activeClubPlayers" :isPlayerMoveable="canSwapPlayers" :currentTab="currentTab" :checkFirstFixture="checkFirstFixture"></striker>
                        </div>
                    </div>
                </div>

                <div class="fixed-bottom-content">
                    <playercarousal :active-players="activePlayers" :sub-players="subPlayers" :currActiveSubPlayer="currActiveSubPlayer" :subPlayerSelected="subPlayerSelected" :selectedPlayerData="selectedSubPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :placement="'top'" :selectedFixtureDate="selectedFixture" :activeClubPlayers="activeClubPlayers" :savedDataForFixture="savedDataForFixtureCount" :isPlayerMoveable="canSwapPlayers" :noSwapForFirstFixture="noSwapForFirstFixture" :currentTab="currentTab" :checkFirstFixture="checkFirstFixture" :manualSwapCheck="manualSwapCheck"></playercarousal>
                     <!-- v-show="canSwapPlayers" -->

                    <div class="action-buttons p-0">
                     <!-- v-if="!canSwapPlayers" -->

                        <div class="row p-2" v-if="savedDataForFixtureCount == 0">
                            <div class="col-6" v-if="!checkFirstFixture">
                                <button type="button" class="btn btn-primary btn-block" @click="saveSuperSubData" :disabled="btnDisabledCheck">ACCEPT AND SAVE</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-block" @click="sendEmails">Confirmation Email</button>
                            </div>
                        </div>

                        <div class="row p-2" v-if="savedDataForFixtureCount > 0">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger btn-block" @click="cancelSuperSubData">CANCEL</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-block" @click="sendEmails">Confirmation Email</button>
                            </div>
                        </div>
                        <div class="row p-2" v-if="savedDataForFixtureCount > 0">
                            <div class="col-12">
                                <button type="button" class="btn btn-theme-danger btn-block" @click="resetAllSupersubs">RESET ALL SUPERSUBS</button>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <fixturesmodal :fixturesForModal="fixturesForModal" :selectedFixtureDate="selectedFixtureDisplay"></fixturesmodal>
    </div>
</template>

<script>

import fixturedatescarousal from './components/fixture_dates_carousal/index.vue';
import pitch from './components/pitch/index.vue';
import goalkeeper from './components/goal_keeper/index.vue';
import defensivefielder from './components/defensive_fielder/index.vue';
import midfielder from './components/midfielder/index.vue';
import striker from './components/striker/index.vue';
import substitutes from './components/substitutes/index.vue';
import fixtures from './components/player_fixtures/index.vue';
import playercarousal from './components/player_carousal/index.vue';
import playerstats from './components/player/stats.vue';
import fixturesmodal from './components/fixtures_modal/index.vue';
import { EventBus } from './event-bus.js';

export default {
    components: {
        pitch, goalkeeper, defensivefielder, midfielder, striker, substitutes, fixtures, playercarousal, playerstats, fixturedatescarousal, fixturesmodal
    },

    props: ['activePlayers', 'subPlayers', 'parentActivePlayers', 'parentSubPlayers', 'pitchUrl', 'division', 'team', 'availableFormations', 'possiblePositions', 'teamClubs', 'futureFixturesDates', 'teamPlayerStatDetails', 'clearSupersubData', 'currentTab', 'superSubFixtureDates'],

    data() {
        return {
            superSubSelectedDate: '',
            currActivePlayer: '',
            currActiveSubPlayer: '',
            playerSelected: false,
            subPlayerSelected: false,
            selectedPlayer: [],
            selectedSubPlayer: [],
            selectedPlayerStats:[],
            displayTeamStats: true,
            popupOpened: false,
            selectedPlayerIndex: 0,
            selectedSubPlayerIndex: 0,
            mobileScreen: false,
            tempActivePlayers: [],
            tempSubPlayers: [],
            allowedFormation: this.availableFormations,
            minMaxNumberForPosition: this.possiblePositions,
            formation: '',
            selectedFixtureDate: '',
            activeClubPlayers: [],
            activePlayersData: [],
            subPlayersData: [],
            savedDataForFixture: '',
            // canSwap: false,
            canSwap: true,
            firstFixture: false,
            totalSwapPlayersCount: 0,
            btnDisabled: false,
            fixturesForModal: [],
            selectedFixtureDateDisplay: '',
            noSwapForFirstFixture: false,
            firstActivePlayer: this.activePlayers,
            manualSwapCheck: false
        };
    },
    computed: {
        selectedFixture() {
            return this.selectedFixtureDate;
        },
        selectedFixtureDisplay() {
            return this.selectedFixtureDateDisplay;
        },
        savedDataForFixtureCount() {
            return this.savedDataForFixture;
        },
        activePlayerOnBenchCount() {
            let count = 0;
            this.subPlayers.forEach((player, k) =>
                {
                    if(_.includes(this.activeClubPlayers,  player.player_id)) {
                        count++;
                    }
                }
            );
            return count;
        },
        canSwapPlayers() {
            return this.canSwap;
        },
        checkFirstFixture() {
            return this.firstFixture;
        },
        btnDisabledCheck() {
            return this.btnDisabled;
        }
    },
    created() {
    },
    watch: {
        clearSupersubData() {
            this.firstFixture = true;
        }
    },
    mounted() {
        let vm = this;

        vm.selectedFixtureDate = _.keys(this.futureFixturesDates)[0];
        vm.selectedFixtureDateDisplay = typeof vm.futureFixturesDates[vm.selectedFixtureDate] != "undefined" ? vm.futureFixturesDates[vm.selectedFixtureDate].date_time : '';

        vm.activePlayersData = _.cloneDeep(vm.activePlayers);
        vm.subPlayersData =  _.cloneDeep(vm.subPlayers);

        vm.tempActivePlayers = _.cloneDeep(vm.activePlayers);
        vm.tempSubPlayers = _.cloneDeep(vm.subPlayers);

        // vm.getPlayersForFixture(vm.selectedFixtureDate, 0);

        this.$root.$on('bv::popover::show', (bvEventObj) => {

            this.$root.$emit('bv::hide::popover')

        })
        this.$root.$on('bv::popover::hide', (bvEventObj) => {

            this.currActivePlayer = '';
            this.currActiveSubPlayer = '';
            this.displayTeamStats = true;
            this.mobileScreen = false;

        })
        this.$root.$on('bv::popover::shown', (bvEventObj) => {

            var flag = this.playerType($(bvEventObj.target).attr('id'));
            if(!flag ) {
                this.currActiveSubPlayer = $(bvEventObj.target).attr('id').replace("subPlayerPopover", "");
                this.currActivePlayer = "00";
            } else {
                this.currActivePlayer = $(bvEventObj.target).attr('id').replace("playerPopover", "");
                this.currActiveSubPlayer = "00";
            }

        })

        EventBus.$on('selectPlayer', player => {
            if(player[1] == "player") {
                this.subPlayerSelected = false;
                this.playerSelected = true;
                this.selectedPlayer = player[0];
            } else {
                this.subPlayerSelected = true;
                this.playerSelected = false;
                this.selectedSubPlayer = player[0];
            }
        });

        EventBus.$on('updateSupersubTempData', function() {
            setTimeout(function() {
                vm.activePlayersData = _.cloneDeep(vm.parentActivePlayers);
                vm.subPlayersData =  _.cloneDeep(vm.parentSubPlayers);
            }, 100)
        });

        EventBus.$on('displayPlayerStat', function(payload) {
            vm.setPlayerData(payload[0]);
        });

        EventBus.$on('setCurrentPlayerId', function(payload) {
            vm.setPlayerData(payload[0]);
            vm.selectedPlayerIndex = payload[1];
        });

        EventBus.$on('setCurrentSubPlayerId', function(payload) {
            vm.setSubPlayerData(payload[0]);
            vm.selectedSubPlayerIndex = payload[1];
        });

        EventBus.$on('setPopUpOpenedFlag', function() {
            vm.popupOpened = !vm.popupOpened;
        });

        EventBus.$on('updateSubstituteProcessStatus', function() {
            if(typeof(vm.selectedSubPlayer.position) != 'undefined' && typeof(vm.selectedPlayer.position) != 'undefined') {

                vm.savedDataForFixture = 0

                vm.$emit('setDateFlag', vm.selectedFixtureDateDisplay)

                let subPlayerposition = vm.selectedSubPlayer.position.toLowerCase();
                let activePlayerposition = vm.selectedPlayer.position.toLowerCase();

                if(subPlayerposition == "cb" || subPlayerposition == "fb") {
                    subPlayerposition = 'df';
                }
                if(subPlayerposition == "dm") {
                    subPlayerposition = 'mf';
                }

                if(activePlayerposition == "cb" || activePlayerposition == "fb") {
                    activePlayerposition = 'df';
                }
                if(activePlayerposition == "dm") {
                    activePlayerposition = 'mf';
                }

                vm.$set(vm.tempActivePlayers[subPlayerposition], vm.activePlayers[subPlayerposition].length, vm.selectedSubPlayer);

                vm.tempActivePlayers[activePlayerposition].splice(vm.selectedPlayerIndex, 1);

                var chkFormation = vm.generateFormation();
                if(chkFormation) {

                    if(vm.selectedPlayer.position == vm.selectedSubPlayer.position) {
                        vm.$set(vm.activePlayers[subPlayerposition], vm.selectedPlayerIndex, vm.selectedSubPlayer);

                    } else {
                        if(vm.selectedSubPlayer.position == "CB") {
                            vm.$set(vm.activePlayers[subPlayerposition], vm.activePlayers[subPlayerposition].length, vm.selectedSubPlayer);
                            // vm.activePlayers[activePlayerposition].splice(4, 5, vm.activePlayers[activePlayerposition]);
                            var cbLen = parseInt(vm.activePlayers['df'].length)-1;
                            var tmp = vm.activePlayers[subPlayerposition][cbLen];
                            vm.activePlayers[subPlayerposition][cbLen] = vm.activePlayers[subPlayerposition][cbLen-1];
                            vm.activePlayers[subPlayerposition][cbLen-1] = tmp;
                            vm.activePlayers[activePlayerposition].splice(vm.selectedPlayerIndex, 1);
                        } else {
                            vm.$set(vm.activePlayers[subPlayerposition], vm.activePlayers[subPlayerposition].length, vm.selectedSubPlayer);
                            vm.activePlayers[activePlayerposition].splice(vm.selectedPlayerIndex, 1);
                        }
                    }


                    vm.$set(vm.subPlayers, vm.selectedSubPlayerIndex, vm.selectedPlayer);

                } else {
                    vm.errorAlert('NOT Done');
                }
                vm.tempActivePlayers = _.cloneDeep(vm.activePlayers);
                vm.selectedPlayer = [];
                vm.selectedSubPlayer = [];
                vm.currActiveSubPlayer = "";
                vm.currActivePlayer = "";
                vm.popupOpened = !vm.popupOpened;
                vm.displayTeamStats = true;
                vm.manualSwapCheck = false;
            }
        });

        EventBus.$on('updatemanualSwap', function() {
            vm.manualSwapCheck = true;
        });

        EventBus.$on('clearSubPlayerData', function() {
            vm.selectedSubPlayer = [];
        });

        EventBus.$on('clearPlayerData', function() {
            vm.selectedPlayer = [];
        });

        EventBus.$on('updateSelectedFixture', function(date) {
            vm.totalSwapPlayersCount = 0;
            // vm.canSwap = false;
            vm.getPlayersForFixture(date, 1);
        });

        EventBus.$on('updateActivePlayersData', function(playerData) {
            vm.checkPlayerSwap(playerData);
            vm.totalSwapPlayersCount += 1;
        });
    },
    methods: {
        openFixturesModal: function() {
            this.axios.post(route('manage.team.supersub.fixtures', {division: this.division}), {clubs: this.teamClubs, date_time: this.selectedFixtureDate})
            .then((response) => {
                this.fixturesForModal = response.data;
                $('#fixtureModal').modal('show');
            })
            .catch((error) => {
                console.log(error);
            });
        },
        checkPlayerSwap: function(playerData) {
            var vm = this;
            vm.tempActivePlayers = _.cloneDeep(vm.activePlayers);
            vm.tempSubPlayers = _.cloneDeep(vm.subPlayers);

            var position = playerData[0].position.toLowerCase();
            var playerPosition = playerData[0].position.toLowerCase();

            if(position == "cb" || position == "fb") {
                position = 'df';
            }
            if(position == "dm") {
                position = 'mf';
            }

            var chkFlag = false;
            var chkFormation = false;

            if(position == "gk") {
                vm.tempActivePlayers[position].forEach((player, k) =>
                    {
                        if(!chkFlag && player.position.toLowerCase() == 'gk') {

                            if(_.includes(vm.activeClubPlayers,  vm.tempActivePlayers['gk'][0].player_id)) {
                                vm.tempActivePlayers['gk'][k].is_processed = 1;
                                vm.tempSubPlayers[playerData[1]].is_processed = 1;

                                vm.$set(vm.tempActivePlayers["gk"], vm.tempActivePlayers["gk"].length, playerData[0]);

                                vm.tempSubPlayers.splice(playerData[1], 1);

                                vm.removeExtraGKFromGroup("gk");

                            } else {
                                vm.tempActivePlayers['gk'][k].is_processed = 1;
                                vm.$set(vm.tempSubPlayers, playerData[1], vm.tempActivePlayers[position][k]);
                                vm.$set(vm.tempActivePlayers[position], k, playerData[0]);
                            }

                            chkFlag = true;
                        }
                    }
                );
            } else {
                vm.tempActivePlayers[position].forEach((player, k) =>
                        {
                            if(!chkFlag && !_.includes(vm.activeClubPlayers, player.player_id)) {
                                vm.tempActivePlayers[position][k].is_processed = 1;
                                if(playerPosition == "fb" || playerPosition == "cb") {
                                    if(playerPosition == vm.tempActivePlayers[position][k].position.toLowerCase())
                                    {
                                        vm.$set(vm.tempSubPlayers, playerData[1], vm.tempActivePlayers[position][k]);
                                        vm.$set(vm.tempActivePlayers[position], k, playerData[0]);
                                        chkFlag = true;
                                    }
                                } else {
                                    vm.$set(vm.tempSubPlayers, playerData[1], vm.tempActivePlayers[position][k]);
                                    vm.$set(vm.tempActivePlayers[position], k, playerData[0]);
                                    chkFlag = true;
                                }
                            }
                        }
                    );

                if(!chkFlag && _.includes(vm.activeClubPlayers, playerData[0].player_id)) {
                    vm.$set(vm.tempActivePlayers[position], vm.tempActivePlayers[position].length, playerData[0]);
                    vm.tempSubPlayers.splice(playerData[1], 1);
                    chkFlag = true;
                }

                if(chkFlag) {
                    chkFormation = vm.generateFormation();
                    if(!chkFormation) {
                        vm.swapPlayersOnTeamPointsBasis();
                    }
                }
            }

            chkFormation = vm.generateFormation();
            if(chkFormation) {
                EventBus.$emit('updateSuperSubsData', [vm.tempActivePlayers, vm.tempSubPlayers]);
            } else {
                vm.errorAlert("ERROR");
            }
        },
        saveSuperSubData: function() {
            var vm = this;
            var arrKeys = _.keys(vm.futureFixturesDates);
            var supersubFirstFixture = false;
            if(arrKeys[0] == vm.selectedFixtureDate) {
                supersubFirstFixture = true;
            }

            vm.btnDisabled = true;

            this.axios.post(route('manage.team.supersub.save', {division: vm.division}), {team_id: vm.team, fixture_date: vm.selectedFixtureDate, active_players: vm.activePlayers, sub_players: vm.subPlayers, first_fixture: supersubFirstFixture})
                .then((response) => {
                    if(response['data'].status == 'success') {

                        let elementId = 'js-' + vm.selectedFixtureDateDisplay.replace(/[-:\s]/gi, '')
                        $('.' + elementId).removeClass('modified-content');

                        // vm.canSwap = false;
                        vm.savedDataForFixture = 1;
                        vm.firstFixture = true;

                        /*if(arrKeys[0] == vm.selectedFixtureDate) {
                            let datetime = vm.futureFixturesDates[arrKeys[0]].date+" "+vm.futureFixturesDates[arrKeys[0]].time;
                            sweet.success("Your supersubs for "+datetime+" will take immediate effect");

                            //original data been changed so update data variables
                            vm.activePlayersData = _.cloneDeep(vm.activePlayers);
                            vm.subPlayersData =  _.cloneDeep(vm.subPlayers);

                            EventBus.$emit('updatePlayersData', [vm.activePlayers, vm.subPlayers]);

                        } else {
                            vm.firstFixture = false;*/
                            vm.successAlert(response['data'].message);
                        // }
                            if(typeof(response['data'].superSubFixtureDates) != "undefined") {
                                EventBus.$emit('updateSuperSubFixturesData', response['data'].superSubFixtureDates);                                
                            }

                        vm.btnDisabled = false;
                        let fixIndex = _.indexOf(arrKeys, vm.selectedFixtureDate);
                        if(arrKeys.length == fixIndex+1) {
                            EventBus.$emit('changeFixture', arrKeys[0]);
                        } else {
                            EventBus.$emit('changeFixture', arrKeys[fixIndex+1]);
                        }

                    } else {
                        vm.errorAlert(response['data'].message);
                        vm.btnDisabled = false;
                    }
            })
            .catch((error) => {
                console.log(error);
                vm.btnDisabled = false;
            });
        },
        sendEmails: function() {
            var vm = this;
            this.axios.post(route('manage.team.supersub.sendemails', {division: vm.division, team: vm.team}))
                .then((response) => {
                    if(response['data'].status == 'success') {
                        sweet.success(response['data'].message);
                    }
                    if (response['data'].status == 'error') {
                        sweet.error(response['data'].message);
                    }
            })
            .catch((error) => {
                console.log(error);
            });
        },
        cancelSuperSubData: function() {
            var vm = this;
            this.axios.post(route('manage.team.supersub.delete', {division: vm.division}), {team_id: vm.team, fixture_date: vm.selectedFixtureDate})
                .then((response) => {
                    if(response['data'].status) {
                        // let elementId = 'js-' + vm.selectedFixtureDateDisplay.replace(/[-:\s]/gi, '')
                        // $('.' + elementId).removeClass('modified-content');

                        if(typeof(response['data'].superSubFixtureDates) != "undefined") {
                            EventBus.$emit('updateSuperSubFixturesData', response['data'].superSubFixtureDates);                                
                        }

                        vm.successAlert('Supersubs cancelled');
                        vm.getPlayersForFixture(vm.selectedFixtureDate)
                    } else {
                        vm.errorAlert('ERROR');
                    }
            })
            .catch((error) => {
                console.log(error);
            });
        },
        resetAllSupersubs: function() {
            var vm = this;
            this.axios.post(route('manage.team.supersub.delete_all', {division: vm.division}), {team_id: vm.team})
                .then((response) => {
                    if(response['data'].status) {
                        /*let elementId = 'js-' + vm.selectedFixtureDateDisplay.replace(/[-:\s]/gi, '')
                        $('.' + elementId).removeClass('modified-content');*/
                        $('.schedule-supersub div.owl-item div.block-section:not("modified-content")').addClass('modified-content');
                        vm.successAlert('All Supersubs reset sucessfully');
                        // vm.getPlayersForFixture(vm.selectedFixtureDate)

                        setTimeout(function(){
                            window.location.href = window.location.origin + window.location.pathname + "?supersub=true";
                        }, 2000);

                    } else {
                        vm.errorAlert('ERROR');
                    }
            })
            .catch((error) => {
                console.log(error);
            });
        },
        editSuperSubData: function() {
            this.canSwap = true;
        },
        removeExtraGKFromGroup: function(position) {
            var vm = this;
            var chkStatus = false;
            var chkFormation = false;

            vm.tempActivePlayers[position].forEach((player, k) =>
                {
                    if( !chkStatus && (player.status != null && player.status != "null") ) {
                        vm.tempActivePlayers['gk'][k].is_processed = 1;
                        vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);
                        vm.tempActivePlayers['gk'].splice(k, 1);
                        chkStatus = true;
                    }
                }
            );

            if(vm.tempActivePlayers[position].length > 1) {
                chkStatus = false;
                vm.tempActivePlayers[position] = _.sortBy(vm.tempActivePlayers[position], ['total']);
                vm.tempActivePlayers[position].forEach((player, k) =>
                    {
                        if( !chkStatus ) {
                            vm.tempActivePlayers['gk'][k].is_processed = 1;
                            vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);
                            vm.tempActivePlayers[position].splice(k, 1);
                            chkFormation = vm.generateFormation();
                            chkStatus = true;
                        }
                    }
                );
            }
        },
        swapPlayersOnTeamPointsBasis: function() {
            var vm = this;
            var validFormations = [];

            vm.allowedFormation.forEach(formationVal => {
                let formation = _.split(formationVal.toString(), "");

                if(formation[1] <= vm.tempActivePlayers['df'].length && formation[2] <= vm.tempActivePlayers['mf'].length && formation[3] <= vm.tempActivePlayers['st'].length) {
                    validFormations.push(formationVal);
                }
            });

            vm.tempActivePlayers['df'] = _.orderBy(vm.tempActivePlayers['df'], ['has_next_fixture','total'], ['desc', 'desc']);
            vm.tempActivePlayers['mf'] = _.orderBy(vm.tempActivePlayers['mf'], ['has_next_fixture','total'], ['desc', 'desc']);
            vm.tempActivePlayers['st'] = _.orderBy(vm.tempActivePlayers['st'], ['has_next_fixture','total'], ['desc', 'desc']);

            var teamTotalPointsArr = [];

            var fbLength = _.filter(vm.tempActivePlayers['df'], { 'position': 'FB' }).length;

            if(fbLength > 2) {
                
                vm.tempActivePlayers['df'] = _.orderBy(vm.tempActivePlayers['df'], ['has_next_fixture','total', 'has_status'], ['desc', 'desc', 'asc']);

                var j = 0;
                vm.tempActivePlayers['df'].forEach((player, k) => {
                    // if(k > fbLength) {
                    if(typeof player.position != 'undefined' && player.position == "FB") {
                        if(j >= 2) {
                            player.is_processed = 1;
                            vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);
                            vm.tempActivePlayers['df'].splice(k, 1);
                        }
                        j++;
                    }
                })
            }

            // if(vm.tempActivePlayers['fb'].length < 2) {
            //     cbLength = vm.tempActivePlayers['cb'].length;

            //     vm.tempActivePlayers['cb'] = _.orderBy(vm.tempActivePlayers['cb'], ['has_next_fixture','total'], ['desc', 'desc']);

            //     vm.tempActivePlayers['cb'].forEach((player, k) => {
            //         if(k == cbLength) {
            //             vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);
            //             vm.tempActivePlayers['cb'].splice(k, 1);
            //         }
            //     })
            // }

            validFormations.forEach(formationVal => {
                let formation = _.split(formationVal.toString(), "");

                var teamTotalPoints = 0;
                var activePlayerTotal = 0;

                vm.tempActivePlayers['df'].forEach((player, k) => {
                    if(k < formation[1]) {
                        teamTotalPoints += player.total;
                        if(_.includes(vm.activeClubPlayers, player.player_id)) {
                            activePlayerTotal++;
                        }
                    }
                })

                vm.tempActivePlayers['mf'].forEach((player, k) => {
                    if(k < formation[2]) {
                        teamTotalPoints += player.total;
                        if(_.includes(vm.activeClubPlayers, player.player_id)) {
                            activePlayerTotal++;
                        }
                    }
                })

                vm.tempActivePlayers['st'].forEach((player, k) => {
                    if(k < formation[3]) {
                        teamTotalPoints += player.total;
                        if(_.includes(vm.activeClubPlayers, player.player_id)) {
                            activePlayerTotal++;
                        }
                    }
                })

                teamTotalPointsArr.push({'formation': formationVal, 'totalPoints': teamTotalPoints, 'activePlayerTotal': activePlayerTotal});

            });

            teamTotalPointsArr = _.orderBy(teamTotalPointsArr, ["activePlayerTotal", "totalPoints"], ["desc", "desc"]);

            var varValidFormationArr = _.split(teamTotalPointsArr[0].formation, "");

            vm.tempActivePlayers['df'].forEach((player, k) => {
                if(k > parseInt(varValidFormationArr[1])-1) {
                    player.is_processed = 1;
                    vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);
                    vm.tempActivePlayers['df'].splice(k, 1);
                }
            })

            vm.tempActivePlayers['mf'].forEach((player, k) => {
                if(k > parseInt(varValidFormationArr[2])-1) {
                    player.is_processed = 1;
                    vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);
                    vm.tempActivePlayers['mf'].splice(k, 1);
                }
            })

            vm.tempActivePlayers['st'].forEach((player, k) => {
                if(k > parseInt(varValidFormationArr[3])-1) {
                    player.is_processed = 1;
                    vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);
                    vm.tempActivePlayers['st'].splice(k, 1);
                }
            })

            var checkFB = 0;
            vm.tempActivePlayers['df'].forEach((player, k) => {
                if(player.position == "FB") {
                    checkFB++;
                }
            });


            //if merge_defenders is No then we must have only 2 FB players. SO following code is extra check for it

            //if lineup has more than 2 FB players
            if(checkFB > 2) {
                vm.tempActivePlayers['df'].forEach((player, k) =>
                    {
                        if( player.position == "FB" && (player.status != null && player.status != "null") && checkFB > 2) {

                            vm.tempSubPlayers.forEach((subplayer, k1) =>
                            {
                                if(subplayer.position == "CB" && (subplayer.status != null && subplayer.status != "null") && checkFB > 2) {

                                    player.is_processed = 1;
                                    vm.$set(vm.tempActivePlayers['df'], k, subplayer);
                                    vm.tempSubPlayers.splice(k1, 1);
                                    vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);

                                    checkFB--;
                                }
                            })

                        }
                    }
                );

                if(checkFB > 2) {
                    vm.tempActivePlayers['df'] = _.sortBy(vm.tempActivePlayers['df'], ['total']);
                    vm.tempSubPlayers = _.sortBy(vm.tempSubPlayers, ['total'], ['desc']);

                    vm.tempActivePlayers['df'].forEach((player, k) =>
                        {
                            if( player.position == "FB" && checkFB > 2) {

                                vm.tempSubPlayers.forEach((subplayer, k1) =>
                                {
                                    if(subplayer.position == "CB" && checkFB > 2) {
                                        player.is_processed = 1;
                                        vm.$set(vm.tempActivePlayers['df'], k, subplayer);
                                        vm.tempSubPlayers.splice(k1, 1);
                                        vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);
                                        checkFB--;
                                    }
                                })

                            }
                        }
                    );
                }
            }

            //if lineup has less than 2 FB players
            if(checkFB > 0 && checkFB < 2) {
                vm.tempActivePlayers['df'].forEach((player, k) =>
                    {
                        if( player.position == "CB" && (player.status != null && player.status != "null") && checkFB < 2) {
                            vm.tempSubPlayers.forEach((subplayer, k1) =>
                            {
                                if(subplayer.position == "FB" && (subplayer.status != null && subplayer.status != "null") && checkFB < 2) {

                                    player.is_processed = 1;
                                    vm.$set(vm.tempActivePlayers['df'], k, subplayer);
                                    vm.tempSubPlayers.splice(k1, 1);
                                    vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);

                                    checkFB++;
                                }
                            })
                        }
                    }
                );

                if(checkFB < 2) {
                    vm.tempActivePlayers['df'] = _.sortBy(vm.tempActivePlayers['df'], ['total']);
                    vm.tempSubPlayers = _.sortBy(vm.tempSubPlayers, ['total'], ['desc']);

                    vm.tempActivePlayers['df'].forEach((player, k) =>
                        {
                            if( player.position == "CB" && checkFB < 2) {

                                vm.tempSubPlayers.forEach((subplayer, k1) =>
                                {
                                    if(subplayer.position == "FB" && checkFB < 2) {
                                        player.is_processed = 1;
                                        vm.$set(vm.tempActivePlayers['df'], k, subplayer);
                                        vm.tempSubPlayers.splice(k1, 1);
                                        vm.$set(vm.tempSubPlayers, vm.tempSubPlayers.length, player);
                                        checkFB++;
                                    }
                                })

                            }
                        }
                    );
                }
            }


            //Formatting FB-CB players like FB-CB-CB-CB-FB positions
            if(vm.tempActivePlayers['df'][0].position != 'DF') {
                var tmpFbArr = [];
                var tmpCbArr = [];
                vm.tempActivePlayers['df'].forEach((player, k) =>
                    {
                        if( player.position == "FB") {
                            tmpFbArr.push(player);
                        } else {
                            tmpCbArr.push(player);
                        }
                    }
                );

                var i = 0;
                vm.tempActivePlayers['df'].forEach((player, k) =>
                    {
                        if( k == 0) {
                            vm.$set(vm.tempActivePlayers['df'], k, tmpFbArr[0]);
                        } else if(k < vm.tempActivePlayers['df'].length-1) {
                            vm.$set(vm.tempActivePlayers['df'], k, tmpCbArr[i]);
                            i++;
                        } else {
                            vm.$set(vm.tempActivePlayers['df'], k, tmpFbArr[1]);
                        }
                    }
                );
            }

        },
        playerType: function (value) {
            return value.includes("playerPopover")
        },
        setPlayerData: function(selected_player) {
            this.selectedPlayerStats = this.teamPlayerStatDetails[selected_player];
            if(this.isMobileScreen()) {
                this.mobileScreen = true;
            } else {
                this.displayTeamStats = false;
            }
        },
        setSubPlayerData: function(selected_player) {
            this.selectedPlayerStats = this.teamPlayerStatDetails[selected_player];
            if(this.isMobileScreen()) {
                this.mobileScreen = true;
            } else {
                this.displayTeamStats = false;
            }
        },
        getPlayersForFixture: function(date, flag) {
            var vm = this;
            vm.btnDisabled = false;
            vm.selectedFixtureDate = date;
            // vm.selectedFixtureDateDisplay = vm.futureFixturesDates[date].date_time;
            vm.selectedFixtureDateDisplay = typeof vm.futureFixturesDates[date] != "undefined" ? vm.futureFixturesDates[date].date_time : '';

            var arrKeys = _.keys(vm.futureFixturesDates);
            vm.activeClubPlayers = [];
            vm.noSwapForFirstFixture = false;
            this.axios.post(route('manage.team.fixture.players', {division: vm.division}), {team_id: vm.team, date: date})
                    .then((response) => {
                        vm.activeClubPlayers = response.data['activeClubPlayers'];
                        vm.savedDataForFixture = response.data['fixture_date_count'];

                        if(vm.savedDataForFixture == 0 && !vm.firstFixture) {
                            let elementId = 'js-' + this.selectedFixtureDateDisplay.replace(/[-:\s]/gi, '')
                            $('.' + elementId).addClass('modified-content');
                        }

                        if(response.data['saved_data'] == 1) {

                            var _tempParentActivePlayers = _.cloneDeep(vm.parentActivePlayers);
                            var _tempParentSubPlayers = _.cloneDeep(vm.parentSubPlayers);

                            var subPlayersIDS = _.map(response.data['subPlayers'], 'player_id');

                            var activePlayersIDS = [];
                            var subPlayersIDS = [];

                            for (var prop in response.data['activePlayers']) {
                                response.data['activePlayers'][prop].forEach((player) =>
                                    {
                                        if(player.next_fixture['FA'].in_lineup == "in" || player.next_fixture['PL'].in_lineup == "in") {

                                            activePlayersIDS.push(player.player_id)
                                        } else {
                                            subPlayersIDS.push(player.player_id)
                                        }
                                    }
                                );
                            }

                            response.data['subPlayers'].forEach((player) =>
                                {
                                    if(typeof player.next_fixture != 'undefined' && (player.next_fixture['FA'].in_lineup == "in" || player.next_fixture['PL'].in_lineup == "in" ))
                                    {
                                        activePlayersIDS.push(player.player_id)
                                    } else {
                                        subPlayersIDS.push(player.player_id)
                                    }
                                }
                            );

                            for (var prop in _tempParentActivePlayers) {
                                _tempParentActivePlayers[prop].forEach((player) =>
                                    {
                                        if(typeof player.next_fixture != 'undefined')
                                        {
                                            if(_.includes(activePlayersIDS, player.player_id)) {
                                                player.next_fixture['FA'].in_lineup = "in";
                                            } else {
                                                player.next_fixture['FA'].in_lineup = "out";
                                            }
                                        }

                                        if(typeof player.next_fixture != 'undefined')
                                        {
                                            if(_.includes(activePlayersIDS, player.player_id)) {
                                                player.next_fixture['PL'].in_lineup = "in";
                                            } else {
                                                player.next_fixture['PL'].in_lineup = "out";
                                            }
                                        }
                                    }
                                );
                            }

                            _tempParentSubPlayers.forEach((player) =>
                                {
                                    if(typeof player.next_fixture != 'undefined')
                                    {
                                        if(_.includes(subPlayersIDS, player.player_id)) {
                                            player.next_fixture['FA'].in_lineup = "out";
                                        } else {
                                            player.next_fixture['FA'].in_lineup = "in";
                                        }
                                    }

                                    if(typeof player.next_fixture != 'undefined')
                                    {
                                        if(_.includes(subPlayersIDS, player.player_id)) {
                                            player.next_fixture['PL'].in_lineup = "out";
                                        } else {
                                            player.next_fixture['PL'].in_lineup = "in";
                                        }
                                    }
                                }
                            );

                            EventBus.$emit('updatePlayersSquadData', [_tempParentActivePlayers, _tempParentSubPlayers]);

                            EventBus.$emit('updateSuperSubsData', [response.data['activePlayers'], response.data['subPlayers']]);

                        } else {

                            EventBus.$emit('updatePlayersSquadData', [vm.parentActivePlayers, vm.parentSubPlayers]);

                            EventBus.$emit('updateSuperSubsData', [response.data['activePlayers'], response.data['subPlayers']]);
                            // EventBus.$emit('updateSuperSubsData', [vm.parentActivePlayers, vm.parentSubPlayers]);

                        }
                        vm.firstFixture = false;

                        $('div.js-owl-carousel-date-info div.js-month').removeClass('pointer-events-none');
                    })
                    .catch((error) => {
                        console.log(error);
                        $('div.js-owl-carousel-date-info div.js-month').removeClass('pointer-events-none');
                    });
            },
        successAlert(msg) {
            sweet.success('Success', msg);
        },
        errorAlert(msg) {
            sweet.error('Error', msg);
        },
        generateFormation() {
            var formation = '';
            var gk = 0;
            var df = 0;
            var mf = 0;
            var st = 0;
            for (var prop in this.tempActivePlayers) {
                this.tempActivePlayers[prop].forEach((player) =>
                    {
                        if(prop == "gk") {
                            gk++;
                        }
                        if(prop == "df" || prop == "cb" || prop == "fb") {
                            df++;
                        }
                        if(prop == "mf" || prop == "dm") {
                            mf++;
                        }
                        if(prop == "st") {
                            st++;
                        }
                    }
                );
            }
            formation = gk+""+df+""+mf+""+st;

            var flag = this.allowedFormation.includes(formation);
            if(flag) {
                this.formation = formation;
            }
            return flag;
        },
        displayPlayerDetails(player_id) {
            this.selectedPlayerStats = this.teamPlayerStatDetails[player_id];
            if(this.isMobileScreen()) {
                this.mobileScreen = true;
            } else {
                this.displayTeamStats = false;
            }
        },
        hidePlayerDetails()
        {
            this.displayTeamStats = true;
            this.mobileScreen = false;
        }
    }
}
</script>
