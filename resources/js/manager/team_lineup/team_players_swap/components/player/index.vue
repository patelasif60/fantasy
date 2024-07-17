<template>
    <div>
		<a href="javascript:void(0);" class="player-wrapper" :class="[(isDisabled ? 'is-disable' : ''), (allowWeekendSwap == 1 ? '' : 'pointer-events-none')]" @click="setCurrentPlayer (player.player_id)">
	        <div class="player-wrapper-img" :class="tshirtClass">
	        </div>
	        <div class="player-wrapper-body">
                <div class="badge-area">
                    <div class="custom-badge" :class="playerPosition">{{ player.position }}</div>
                    <div class="custom-badge" v-if="player.status">
                        <img :src="'/assets/frontend/img/status/' + player.status.status.toLowerCase().trim().split(' ').join('') + '.svg'" class="status-img" draggable="false" :title="player.status.description">
                    </div>
                </div>

                <div class="player-wrapper-title">{{ player.player_last_name }}</div>

                <div class="player-wrapper-description">
                    <div class="player-wrapper-text">
                        <div class="player-fixture-sch">
                            <span class="schedule-day font-weight-normal">
                                {{ nextFixtureClub() }}
                            </span>
                            <span class="schedule-day font-weight-normal">
                                {{ nextFixtureDt() }}
                            </span>

                            <!-- <span class="schedule-date">{{ nextFixtureDt() }}</span> -->
                        </div>
                        <!-- <div class="player-points">
                            <span class="points font-weight-bold">{{ playerPoints }}</span>
                        </div> -->
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
    props: ['player', 'currActivePlayer', 'playerSelected', 'selectedPlayerData', 'popupOpened', 'selectedPlayer', 'selectedSubPlayer', 'selectedPlayerIndex','isPlayerMoveable', 'minMaxNumberForPosition', 'groupCount', 'activePlayers', 'allowWeekendSwap', 'currentTab'],
    data() {
        return {
            show: false
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
        isSelected() {
            return this.selectedPlayerData.player_id == this.player.player_id;
        },
        isDisabled() {

            var playerPositions;
            var currPlayerPosition = this.player.position.toLowerCase();

            if(typeof(this.selectedSubPlayer) != "undefined" && this.selectedSubPlayer.length != 0 && this.currActivePlayer != '00')
            {
                var position = this.selectedSubPlayer.position.toLowerCase();
                switch (position)
                {
                    case 'gk':

                        playerPositions = ['gk'];
                        break;

                    case 'cb':

                        playerPositions = ['df', 'cb'];

                        position = 'df';

                        if(this.minMaxNumberForPosition[position].min <= this.activePlayers[position].length && this.minMaxNumberForPosition[position].max > this.activePlayers[position].length) {

                            if(this.minMaxNumberForPosition['mf'].min < this.activePlayers['mf'].length && this.minMaxNumberForPosition['mf'].max >= this.activePlayers['mf'].length) {
                                playerPositions.push('dm');
                                playerPositions.push('mf');
                            }

                            if(this.minMaxNumberForPosition['st'].min < this.activePlayers['st'].length && this.minMaxNumberForPosition['st'].max >= this.activePlayers['st'].length) {
                                playerPositions.push('st');
                            }
                        }

                        break;

                    case 'fb':

                        playerPositions = ['df', 'fb'];
                        break;

                    case 'df':

                        playerPositions = ['df', 'cb', 'fb'];

                        if(this.minMaxNumberForPosition[position].min <= this.activePlayers[position].length && this.minMaxNumberForPosition[position].max > this.activePlayers[position].length) {
                            if(this.minMaxNumberForPosition['mf'].min < this.activePlayers['mf'].length && this.minMaxNumberForPosition['mf'].max >= this.activePlayers['mf'].length) {
                                playerPositions.push('dm');
                                playerPositions.push('mf');
                            }

                            if(this.minMaxNumberForPosition['st'].min < this.activePlayers['st'].length && this.minMaxNumberForPosition['st'].max >= this.activePlayers['st'].length) {
                                playerPositions.push('st');
                            }
                        }
                        break;

                    case 'dm':
                    case 'mf':

                        playerPositions = ['dm', 'mf'];
                        position = 'mf';

                        if(this.minMaxNumberForPosition[position].min <= this.activePlayers[position].length && this.minMaxNumberForPosition[position].max > this.activePlayers[position].length) {
                            if(this.minMaxNumberForPosition['df'].min < this.activePlayers['df'].length && this.minMaxNumberForPosition['df'].max >= this.activePlayers['df'].length) {
                                playerPositions.push('df');
                                playerPositions.push('cb');
                            }
                            if(this.minMaxNumberForPosition['st'].min < this.activePlayers['st'].length && this.minMaxNumberForPosition['st'].max >= this.activePlayers['st'].length) {
                                playerPositions.push('st');
                            }
                        }
                        break;

                    case 'st':

                        playerPositions = ['st'];

                        if(this.minMaxNumberForPosition[position].min <= this.activePlayers[position].length && this.minMaxNumberForPosition[position].max > this.activePlayers[position].length) {
                            if(this.minMaxNumberForPosition['df'].min < this.activePlayers['df'].length && this.minMaxNumberForPosition['df'].max >= this.activePlayers['df'].length) {
                                playerPositions.push('df');
                                playerPositions.push('cb');
                            }
                            if(this.minMaxNumberForPosition['mf'].min < this.activePlayers['mf'].length && this.minMaxNumberForPosition['mf'].max >= this.activePlayers['mf'].length) {
                                playerPositions.push('dm');
                                playerPositions.push('mf');
                            }
                        }
                        break;

                    default:
                        break;
                }

            }

            return (this.selectedSubPlayer.length != 0 && this.currActivePlayer != '00' && _.indexOf(playerPositions, currPlayerPosition) < 0) || (this.currActivePlayer == '00' && this.selectedPlayerData.player_id != this.player.player_id) || (this.selectedPlayer.length != 0 && this.selectedPlayerData.player_id != this.player.player_id);
        },
    	playerPosition() {
    		return "is-"+this.player.position.toLowerCase();
    	},
    	playerPoints() {
    		return this.player.total == null ? 0 : this.player.total;
    	},
        // canClick() {
        //     // return this.currActivePlayer == '';
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
                EventBus.$emit('clearPlayerData');
                this.show = false;
            }
        },
        finishedProcess (value) {
            this.show = value;
            EventBus.$emit('updateSubstituteProcessStatus', !this.popupOpened);
        },
        setCurrentPlayer (player_id) {
            EventBus.$emit('setCurrentPlayerId', [player_id, this.selectedPlayerIndex]);
            EventBus.$emit('selectPlayer', [this.player, 'player']);
            if(this.selectedPlayerData.player_id != this.player.player_id) {
                EventBus.$emit('checkSuperSubData');
                EventBus.$emit('updateSubstituteProcessStatus', !this.popupOpened);
            } else {
                EventBus.$emit('clearPlayerData');
            }
        },
        isPlayerMove() {
            return (this.isPlayerMoveable === 'false' || typeof this.isPlayerMoveable === 'undefined') ? false : true;
        },
        nextFixtureClub() {
            var fixture = '';
            if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                fixture = this.player.next_fixture['PL'];
            } else {
                fixture = this.player.next_fixture['FA'];
            }
            if(typeof(fixture.short_code) != 'undefined') {
                if(this.isMobileScreen()) {
                    if(fixture.type == 'H')
                        return fixture.short_code + '(h)';
                    else
                        return fixture.short_code + '(a)';
                } else {
                    if(fixture.type == 'H')
                        return fixture.short_code + ' (h)';
                    else
                        return fixture.short_code + ' (a)';
                }
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
    },
    mounted() {
    },
}
</script>
