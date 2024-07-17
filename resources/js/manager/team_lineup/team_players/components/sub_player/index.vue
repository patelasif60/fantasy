<template>
    <div>
        <a href="javascript:void(0);" class="player-list-info" data-togle="sidebar" @click="$emit('displayPlayerStat', player.player_id)" data-toggle="modal" data-target="#players-info">
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
                            <!-- <span class="font-weight-normal">{{nextFixtureClub()}}&nbsp;</span>
                            <span class="points font-weight-bold">{{ playerPoints }}</span> -->

                            <div>
                                <span class="font-weight-normal">{{nextFixtureClub()}}</span>
                                <span class="schedule-day font-weight-normal d-md-none">
                                    {{ nextFixtureDt() }}
                                </span>
                            </div>
                            <span class="points font-weight-bold">{{ playerPoints }}</span>
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
    props: ['player', 'selectedPlayerId', 'currentTab'],
    data() {
        return {

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
            return this.selectedPlayerId == this.player.player_id;
        },
        selectedClass() {
            if(this.isSelected) {
                return "is-selected";
            }
        },
        playerPosition() {
            return "is-"+this.player.position.toLowerCase();
        },
        playerPoints() {
            return this.player[this.currentTab].total == null ? 0 : this.player[this.currentTab].total;
        }
    },
    mounted() {

    },
    methods: {
        setCurrentPlayer(player_id) {
            EventBus.$emit('displayPlayerStat', player_id);
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
                        return fixture.short_code + ' (h)';
                    else
                        return fixture.short_code + ' (a)';
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
    }
}
</script>
