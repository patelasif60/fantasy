<template>
    <div v-cloak>
        <div class="pitch-layout">
            <div class="pitch-area">
                <pitch :pitch-url="pitchUrl"></pitch>
                <div class="pitch-players-standing">
                    <div class="standing-area">
                        <div class="standing-view">
                            <goalkeeper :activePlayers="activePlayers" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :playerPointsStats="playerPointsStats" :allowWeekendSwap="allowWeekendSwap" :currentTab="currentTab"></goalkeeper>
                            <defensivefielder :activePlayers="activePlayers" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :allowWeekendSwap="allowWeekendSwap" :currentTab="currentTab"></defensivefielder>
                            <midfielder :activePlayers="activePlayers" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :allowWeekendSwap="allowWeekendSwap" :currentTab="currentTab"></midfielder>
                            <striker :activePlayers="activePlayers" :currActivePlayer="currActivePlayer" :playerSelected="playerSelected" :selectedPlayerData="selectedPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :allowWeekendSwap="allowWeekendSwap" :currentTab="currentTab"></striker>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fixed-bottom-content">
                <playercarousal  :active-players="activePlayers" :sub-players="subPlayers" :currActiveSubPlayer="currActiveSubPlayer" :subPlayerSelected="subPlayerSelected" :selectedPlayerData="selectedSubPlayer" :selectedPlayer="selectedPlayer" :selectedSubPlayer="selectedSubPlayer" :popupOpened="popupOpened" :minMaxNumberForPosition="minMaxNumberForPosition" :placement="'top'" :allowWeekendSwap="allowWeekendSwap" :currentTab="currentTab"></playercarousal>
            </div>
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
import playerstats from './components/player/stats.vue';

import { EventBus } from './event-bus.js';


export default {
    components: {
        pitch, goalkeeper, defensivefielder, midfielder, striker, substitutes, fixtures, playercarousal, playerstats
    },
    props: ['activePlayers', 'subPlayers','isPlayerMoveable','pitchUrl', 'division', 'team', 'availableFormations', 'possiblePositions', 'teamStats', 'teamPlayerStatDetails', 'allowWeekendSwap', 'currentTab'],
    data() {
        return {
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
            // allowedFormation: ['1-4-4-2', '1-4-5-1', '1-4-3-3', '1-5-3-2', '1-5-4-1']
            allowedFormation: this.availableFormations,
            // minMaxNumberForPosition: {fb: {min: 2, max: 2}, cb: {min: 2, max: 3}, df: {min: 4, max: 5}, mf: {min: 3, max: 5}, st: {min: 1, max: 3}},
            minMaxNumberForPosition: this.possiblePositions,
            formation: '',
            playerPointsStats: [],
        };
    },
    computed: {
    },
    created() {
    },
    watch: {
    },
    mounted() {

        let vm = this;
        vm.tempActivePlayers = _.cloneDeep(vm.activePlayers);
        
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

        EventBus.$on('checkSuperSubData', function() {
            vm.checkSuperSubData();
        });

        EventBus.$on('setCurrentPlayerId', function(payload) {
            vm.selectedPlayerIndex = payload[1];
        });

        EventBus.$on('setCurrentSubPlayerId', function(payload) {
            vm.selectedSubPlayerIndex = payload[1];
        });

        EventBus.$on('setPopUpOpenedFlag', function() {
            vm.popupOpened = !vm.popupOpened;
        });

        EventBus.$on('updateSubstituteProcessStatus', function() {
            if(typeof(vm.selectedSubPlayer.position) != 'undefined' && typeof(vm.selectedPlayer.position) != 'undefined') {
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

                    if(typeof vm.selectedSubPlayer.next_fixture['FA'].in_lineup != 'undefined')
                    {
                        vm.selectedSubPlayer.next_fixture['FA'].in_lineup = "in";
                    }

                    if(typeof vm.selectedSubPlayer.next_fixture['PL'].in_lineup != 'undefined') 
                    {
                        vm.selectedSubPlayer.next_fixture['PL'].in_lineup = "in";
                    }

                    if(vm.selectedPlayer.position == vm.selectedSubPlayer.position) {
                        vm.$set(vm.activePlayers[subPlayerposition], vm.selectedPlayerIndex, vm.selectedSubPlayer);
                    } else {
                        if(vm.selectedSubPlayer.position == "CB") {
                            vm.$set(vm.activePlayers[subPlayerposition], vm.activePlayers[subPlayerposition].length, vm.selectedSubPlayer);
                            
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

                    if(typeof vm.selectedPlayer.next_fixture['FA'].in_lineup != 'undefined')
                    {
                        vm.selectedPlayer.next_fixture['FA'].in_lineup = "out";
                    } else {
                        vm.selectedPlayer.next_fixture['PL'].in_lineup = "out";
                    }

                    vm.$set(vm.subPlayers, vm.selectedSubPlayerIndex, vm.selectedPlayer);
                    
                    this.axios.post(route('manage.team.player.swap', {division: vm.division , team: vm.team}), {lineup_player: vm.selectedPlayer.player_id, sub_player: vm.selectedSubPlayer.player_id, formation: vm.formation})
                    .then((response) => {
                        if(response['data'].status === 'error') {
                            vm.errorAlert(response['data'].message);
                        } else {
                            vm.successAlert(response['data'].message);
                            vm.updatePlayersSquadData([vm.activePlayers, vm.subPlayers]);
                            //original data been changed so update data variables
                            vm.updateSuperSubsData();
                            vm.updateClearSupersubDataFlag();
                        }
                    })
                    .catch((error) => {
                        vm.errorAlert('NOT Done');
                    });

                } else {
                    vm.errorAlert('NOT DONE - Team lineup formation is invalid');
                }
                vm.tempActivePlayers = _.cloneDeep(vm.activePlayers);
                vm.selectedPlayer = [];
                vm.selectedSubPlayer = [];
                vm.currActiveSubPlayer = "";
                vm.currActivePlayer = "";
                vm.popupOpened = !vm.popupOpened;
                vm.displayTeamStats = true;
            }
        });

        EventBus.$on('clearSubPlayerData', function() {
            vm.selectedSubPlayer = [];
        });

        EventBus.$on('clearPlayerData', function() {
            vm.selectedPlayer = [];
        });
    },
    methods: {
        playerType: function (value) {
            return value.includes("playerPopover")
        },
        updateSuperSubsData: function() {
            this.$emit('updateSuperSubsData', [this.activePlayers, this.subPlayers, 1]);
        },
        updatePlayersSquadData: function(players) {
            this.$emit('updatePlayersSquadData', players);
        },
        updateClearSupersubDataFlag: function() {
            this.$emit('updateClearSupersubDataFlag')
        },
        checkSuperSubData: function() {
            this.axios.get(route('manage.team.supersub.check', {division: this.division, team: this.team}))
                .then((response) => {
                    if(response.data > 0) {
                        sweet.error('Warning', "If you complete this process, your supersubs will be cancelled");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        // getPlayerStats: function() {
        //     this.axios.get(route('manage.team.player.stats', {team: this.team}))
        //         .then((response) => {
        //             this.teamPlayerStatDetails = response.data;
        //         })
        //         .catch((error) => {
        //             console.log(error);
        //         });
        // },
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
