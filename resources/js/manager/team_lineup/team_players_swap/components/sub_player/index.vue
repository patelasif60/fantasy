<template>
	<div :class="[allowWeekendSwap == 1 ? '' : 'pointer-events-none']">
		<a href="javascript:void(0);" class="player-list-info" :class="[(isDisabled ? 'player-wrapper opacity-90 is-disable' : '')]" data-togle="sidebar" @click="setCurrentPlayer(player.player_id);">
            <div class="player-wrapper side-by-side" :class="selectedClass">
                <div class="player-wrapper-img" :class="tshirtClass">
                    <div class="player-status" v-if="player.status">
                        <img :src="'/assets/frontend/img/status/' + player.status.status.toLowerCase().trim().split(' ').join('') + '.svg'" draggable="false" :title="player.status.description">
                    </div>
                </div>
                <div class="player-wrapper-body">
                    <div class="badge-area">
                        <div class="custom-badge" :class="playerPosition">{{ player.position }}</div>
                    </div>

                    <div class="player-wrapper-title">{{ player.player_last_name }}</div>
                    <div class="player-wrapper-description">
                        <div class="player-wrapper-text">
                            <!-- <div class="player-points"> -->
                                <!-- <span class="font-weight-normal">{{nextFixtureClub()}}</span> -->
                                <!-- <span class="points font-weight-bold">{{ playerPoints }}</span> -->
                                <!-- <span v-if="!isMobileScreen()">{{nextFixtureClub()}}</span>
                                <span v-else class="points">{{ playerPoints }} pts</span> -->
                            <!-- </div> -->

                            <div>
                                <span class="font-weight-normal">{{nextFixtureClub()}}</span>
                                <span class="schedule-day font-weight-normal d-md-none">
                                    {{ nextFixtureDt() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </a>

	</div>
</template>

<script>

import { EventBus } from '../../event-bus.js';

export default {
    components: {
    },
    props: ['player', 'currActiveSubPlayer', 'subPlayerSelected', 'selectedPlayerData', 'popupOpened', 'selectedPlayer', 'selectedSubPlayer', 'playerIndex', 'minMaxNumberForPosition', 'activePlayers', 'placement', 'allowWeekendSwap', 'currentTab'],
    data() {
        return {
            show: false,
            activePlayer: this.currActiveSubPlayer,
        };
    },
    computed: {
        tshirtClass() {

            let tshirt = this.player.position.toLowerCase() == "gk" ? this.player.short_code.toLowerCase()+"_gk" : this.player.short_code.toLowerCase()+"_player";
            if(this.isSelected) {
                tshirt += "-selected";
            }
            return tshirt;

        },
        selectedClass() {
            if(this.isSelected) {
                return "is-selected";
            }
        },
        isSelected() {
            return this.selectedPlayerData.player_id == this.player.player_id;
        },
        isDisabled() {

            var playerPositions;
            var currPlayerPosition = this.player.position.toLowerCase();

            if(this.selectedPlayer.length != 0 && this.currActiveSubPlayer != '00')
            {
                var position = this.selectedPlayer.position.toLowerCase();
                switch (position)
                {
                    case 'gk':

                        playerPositions = ['gk'];
                        break;

                    case 'cb':

                        playerPositions = ['df', 'cb'];

                        position = 'df';
                        if(this.minMaxNumberForPosition[position].min < this.activePlayers[position].length && this.minMaxNumberForPosition[position].max >= this.activePlayers[position].length) {

                            if(this.minMaxNumberForPosition['mf'].max > this.activePlayers['mf'].length) {
                                playerPositions.push('dm');
                                playerPositions.push('mf');
                            }

                            if(this.minMaxNumberForPosition['st'].max > this.activePlayers['st'].length) {
                                playerPositions.push('st');
                            }
                        }

                        break;

                    case 'fb':

                        playerPositions = ['df', 'fb'];
                        break;

                    case 'df':

                        playerPositions = ['df', 'cb', 'fb'];

                        if(this.minMaxNumberForPosition[position].min < this.activePlayers[position].length && this.minMaxNumberForPosition[position].max >= this.activePlayers[position].length) {

                            if(this.minMaxNumberForPosition['mf'].max > this.activePlayers['mf'].length) {
                                playerPositions.push('dm');
                                playerPositions.push('mf');
                            }

                            if(this.minMaxNumberForPosition['st'].max > this.activePlayers['st'].length) {
                                playerPositions.push('st');
                            }
                        }
                        break;

                    case 'dm':
                    case 'mf':

                        playerPositions = ['dm', 'mf'];
                        position = 'mf';

                        if(this.minMaxNumberForPosition[position].min < this.activePlayers[position].length && this.minMaxNumberForPosition[position].max >= this.activePlayers[position].length) {
                            if(this.minMaxNumberForPosition['df'].max > this.activePlayers['df'].length) {
                                playerPositions.push('df');
                                playerPositions.push('cb');
                            }
                            if(this.minMaxNumberForPosition['st'].max > this.activePlayers['st'].length) {
                                playerPositions.push('st');
                            }
                        }
                        break;

                    case 'st':

                        playerPositions = ['st'];

                        if(this.minMaxNumberForPosition[position].min < this.activePlayers[position].length && this.minMaxNumberForPosition[position].max >= this.activePlayers[position].length) {

                            if(this.minMaxNumberForPosition['df'].max > this.activePlayers['df'].length) {
                                playerPositions.push('df');
                                playerPositions.push('cb');
                            }
                            if(this.minMaxNumberForPosition['mf'].max > this.activePlayers['mf'].length) {
                                playerPositions.push('dm');
                                playerPositions.push('mf');
                            }
                        }
                        break;

                    default:
                        break;
                }
            }

            return (this.selectedPlayer.length != 0 && this.currActiveSubPlayer != '00' && _.indexOf(playerPositions, currPlayerPosition) < 0) || (this.currActiveSubPlayer == '00' && this.selectedPlayerData.player_id != this.player.player_id) || (this.selectedSubPlayer.length != 0 && this.selectedPlayerData.player_id != this.player.player_id);
        },
    	playerPosition() {
    		return "is-"+this.player.position.toLowerCase();
    	},
    	playerPoints() {
    		return this.player.total == null ? 0 : this.player.total;
    	},
        // canClick: function() {
        //     return this.selectedPlayerData.player_id != this.player.player_id
        // }
    },
    mounted() {

    },
    methods: {
        hidePopover (value) {
            if(value != 'cancel') {
                this.show = value;
                EventBus.$emit('setPopUpOpenedFlag', !this.popupOpened);
            } else {
                EventBus.$emit('clearSubPlayerData');
                this.show = false;
            }
        },
        finishedProcess (value) {
            this.show = value;
            EventBus.$emit('updateSubstituteProcessStatus', !this.popupOpened);
        },
        setCurrentPlayer(player_id) {
            EventBus.$emit('setCurrentSubPlayerId', [player_id, this.playerIndex]);
            EventBus.$emit('selectPlayer', [this.player, 'subplayer']);
            if(this.selectedPlayerData.player_id != this.player.player_id) {
                EventBus.$emit('checkSuperSubData');
                EventBus.$emit('updateSubstituteProcessStatus', !this.popupOpened);
            } else {
                EventBus.$emit('clearSubPlayerData');
            }
        },
        nextFixtureClub() {
            var fixture = '';
            if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                fixture = this.player.next_fixture['PL'];
            } else {
                fixture = this.player.next_fixture['FA'];
            }

            if(typeof(fixture.short_code) != 'undefined') {
                // if(this.isMobileScreen()) {
                //     return fixture.short_code
                // } else {
                    if(fixture.type == 'H')
                        return fixture.short_code + ' (h)';
                    else
                        return fixture.short_code + ' (a)';
                // }
            }
        },
        nextFixtureDt() {
            var fixture = '';
            if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                fixture = this.player.next_fixture['PL'];
            } else {
                fixture = this.player.next_fixture['FA'];
            }
            if(typeof(fixture.date) != 'undefined') {
                return fixture.date;
            }
        },
    }
}
</script>
