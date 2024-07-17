<template>
    <!-- <div class="popover bs-popover-top"> -->
        <div class="lineup-modal">
            <div class="lineup-modal-body">
                <div class="player-wrapper-status" v-if="player.status != null">
                    <span>
                        <img :src="'/assets/frontend/img/status/' + player.status.status.toLowerCase().trim().split(' ').join('') + '.svg'" class="img-status">
                    </span> 
                    {{player.status.description}}
                    <span v-if="player.status.status == 'Suspended' || player.status.status == 'Injured' || player.status.status == 'International'">
                        until {{ player.status.end_date }}
                    </span>

                </div>

                <a href="javascript:void(0);" class="link-nostyle lineup-modal-stepper">
                    <div class="lineup-modal-content">
                        <div class="lineup-modal-label">
                            <div class="custom-badge custom-badge-xl is-square" :class="playerPosition">{{ player.position }}</div>
                        </div>
                        <div class="lineup-modal-body">
                            <div class="lineup-modal-title">
                                <a href="javascript:void(0);" class="player-wrapper text-dark" data-toggle="modal" data-target="#players-info">
                                    {{typeof player.player_first_name != "undefined" && player.player_first_name != '' && player.player_first_name != null ? player.player_first_name+" " : "" }}{{player.player_last_name}}
                                </a>
                            </div>
                            <div class="lineup-modal-text">{{ player.club_name }}</div>
                        </div>
                    </div>
                </a>

                <ul class="list-unstyled">
                    <li>week<span class="points">{{ player.week_total }} pts</span></li>
                    <li>month<span class="points">{{ player.month_total }} pts</span></li>
                    <li>total<span class="points">{{ player.total }} pts</span></li>
                </ul>

                <div class="mt-3"></div>

                <a href="javascript:void(0);" class="link-nostyle lineup-modal-stepper" v-if="popupOpened && !(currActivePlayer == '' && currActiveSubPlayer == '00') && !(currActivePlayer == '00' && currActiveSubPlayer == '')">
                    <div class="lineup-modal-content">
                        <div class="lineup-modal-label">
                            <img src="/assets/frontend/img/status/transfer.svg" class="lbl-img">
                        </div>
                        <div class="lineup-modal-body" v-if="currActiveSubPlayer == '00' && currActivePlayer != '' && typeof(selectedSubPlayer) != 'undefined'">
                            <div class="lineup-modal-title">
                                {{typeof selectedSubPlayer.player_first_name != "undefined" && selectedSubPlayer.player_first_name != '' && selectedSubPlayer.player_first_name != null ? selectedSubPlayer.player_first_name+" " : "" }}{{selectedSubPlayer.player_last_name}}
                            </div>
                            <div class="lineup-modal-text">{{ selectedSubPlayer.club_name }}</div>
                        </div>
                        <div class="lineup-modal-body" v-if="currActivePlayer == '00' && currActiveSubPlayer != '' && typeof(selectedPlayer) != 'undefined'">
                            <div class="lineup-modal-title">
                                {{typeof selectedPlayer.player_first_name != "undefined" && selectedPlayer.player_first_name != '' && selectedPlayer.player_first_name != null ? selectedPlayer.player_first_name+" " : "" }}{{selectedPlayer.player_last_name}}
                            </div>
                            <div class="lineup-modal-text">{{ selectedPlayer.club_name }}</div>
                        </div>
                    </div>
                </a>

                <div class="mt-2"></div>

                
                    <button type="button" class="btn btn-primary btn-block" @click="substitutePlayer" v-if="!popupOpened">
                        <span v-if="currActivePlayer == '00' && currActiveSubPlayer != '' && typeof(selectedPlayer) != 'undefined'">Substitute on</span>
                        <span v-if="currActiveSubPlayer == '00' && currActivePlayer != '' && typeof(selectedSubPlayer) != 'undefined'">Substitute off</span>
                    </button>
                    <button type="button" class="btn btn-primary btn-block" @click="finishedProcess" v-if="popupOpened">
                        <span v-if="currActivePlayer == '00' && currActiveSubPlayer != '' && typeof(selectedPlayer) != 'undefined'">Substitute on</span>
                        <span v-if="currActiveSubPlayer == '00' && currActivePlayer != '' && typeof(selectedSubPlayer) != 'undefined'">Substitute off</span>
                    </button>
                
                <button type="button" class="btn btn-outline-dark btn-block" @click="hidePopup">Cancel</button>
            </div>
        </div>
    <!-- </div> -->
</template>

<script>

import { EventBus } from '../../event-bus.js';

export default {
    components: {
        
    },
    props: ['player', 'playerSelected', 'subPlayerSelected', 'type', 'popupOpened', 'currActivePlayer', 'currActiveSubPlayer', 'selectedPlayer', 'selectedSubPlayer'],
    data() {
        return {
            
        };
    },
    computed: {
        playerPosition() {
    		return "is-"+this.player.position.toLowerCase();
    	}
    },
    mounted() {
    },
    methods: {
        hidePopup() {
            // this.slimScroll();
            this.$emit('hidePopover', 'cancel');
        },
        substitutePlayer() {
            // this.slimScroll();
            this.$emit('hidePopover', false);
        },
        finishedProcess() {
            // this.slimScroll();
            this.$emit('finishedProcess', false);
        }
    }
}
</script>