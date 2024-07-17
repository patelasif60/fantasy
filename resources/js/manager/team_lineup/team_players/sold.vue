<template>
    <div class="table-responsive">
        <table class="table custom-table table-hover m-0 fixed-column">
            <thead class="thead-dark">
                <tr>
                    <th>PLAYER
                    </th>
                    <template>
                        <th class="text-center">£M</th>
                        <th class="text-center">PLD</th>
                        <th class="text-center">GLS</th>
                        <th class="text-center">ASS</th>
                        <th class="text-center">CS</th>
                        <th class="text-center">GA</th>
                        <th class="text-center" v-if="columns.club_win > 0">CW</th>
                        <th class="text-center" v-if="columns.red_card > 0">RC</th>
                        <th class="text-center" v-if="columns.yellow_card > 0">YC</th>
                        <th class="text-center" v-if="columns.own_goal > 0">OG</th>
                        <th class="text-center" v-if="columns.penalty_missed > 0">PM</th>
                        <th class="text-center" v-if="columns.penalty_save > 0">PS</th>
                        <th class="text-center" v-if="columns.goalkeeper_save_x5 > 0">5GS</th>
                        <th class="text-center">TOT</th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <template v-for="players in soldPlayer">
                    <tr>
                        <td class="position">
                            <div class="player-wrapper">
                                <span class="custom-badge custom-badge-lg is-gk" :class="playerPosition(players)">{{players.position}}</span>
                                <div>
                                    <a href="javascript:void(0);" class="team-name link-nostyle text-capitalize" @click="displaySquadPlayerDetails (players.id)">
                                    {{typeof players.player_first_name != "undefined" && players.player_first_name != '' && players.player_first_name != null ? players.player_first_name[0]+" " : "" }}{{ players.player_last_name }} <small>{{ players.short_code }}</small></a>
                                </div>
                            </div>
                        </td>
                        <template>
                            <td class="text-center">{{transfer_value(players)}}</td>
                            <td class="text-center">{{played(players)}}</td>
                            <td class="text-center">{{goals(players)}}</td>
                            <td class="text-center">{{assists(players)}}</td>
                            <td class="text-center">{{cleanSheets(players)}}</td>
                            <td class="text-center">{{goalAgaints(players)}}</td>
                            <td class="text-center" v-if="columns.club_win > 0">{{clubWin(players)}}</td>
                            <td class="text-center" v-if="columns.red_card > 0">{{redCard(players)}}</td>
                            <td class="text-center" v-if="columns.yellow_card > 0">{{yellowCard(players)}}</td>
                            <td class="text-center" v-if="columns.own_goal > 0">{{ownGoal(players)}}</td>
                            <td class="text-center" v-if="columns.penalty_missed > 0">{{penaltyMissed(players)}}</td>
                            <td class="text-center" v-if="columns.penalty_save > 0">{{penaltySaved(players)}}</td>
                            <td class="text-center" v-if="columns.goalkeeper_save_x5 > 0">{{goalKeeperSave(players)}}</td>
                            <td class="text-center">{{total(players)}}</td>
                        </template>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>


<script>
    export default {
        components: {
        },
        props: ['soldPlayer','columns','currentTab'],
        data() {
             return {
                showMore: false,
                showAdditionalColumns: false,
            };
        },
        mounted() {
        },
        computed: {
        },
        methods: {

            displaySquadPlayerDetails(player_id) {

                this.$emit('displaySquadPlayerDetails', player_id);
            },
            playerPosition(player) {
                return "is-"+player.position.toLowerCase();
            },
            transfer_value(player) {
                return player.transfer_value == null ? "0.00" : player.transfer_value;
            },
            played(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.played == null ? 0 : players.played;
                } else {
                    return players.fa_played == null ? 0 : players.fa_played;
                }
            },
            goals(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.goals == null ? 0 : players.goals;
                } else {
                    return players.fa_goals == null ? 0 : players.fa_goals;
                }
            },
            assists(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.assists == null ? 0 : players.assists;
                } else {
                    return players.fa_assists == null ? 0 : players.fa_assists;
                }
            },
            cleanSheets(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.clean_sheets == null ? 0 : players.clean_sheets;
                } else {
                    return players.fa_clean_sheets == null ? 0 : players.fa_clean_sheets;
                }
            },
            goalAgaints(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.goal_against == null ? 0 : players.goal_against;
                } else {
                    return players.fa_goal_against == null ? 0 : players.fa_goal_against;
                }
            },
            clubWin(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.club_win == null ? 0 : players.club_win;
                } else {
                    return players.fa_club_win == null ? 0 : players.fa_club_win;
                }
            },
            redCard(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.red_card == null ? 0 : players.red_card;
                } else {
                    return players.fa_red_card == null ? 0 : players.fa_red_card;
                }
            },
            yellowCard(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.yellow_card == null ? 0 : players.yellow_card;
                } else {
                    return players.fa_yellow_card == null ? 0 : players.fa_yellow_card;
                }
            },
            ownGoal(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.own_goal == null ? 0 : players.own_goal;
                } else {
                    return  players.fa_own_goal == null ? 0 : players.fa_own_goal;
                }
            },
            penaltyMissed(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                     return players.penalty_missed == null ? 0 : players.penalty_missed;
                } else {
                    return players.fa_penalty_missed == null ? 0 : players.fa_penalty_missed;
                }
            },
            penaltySaved(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.penalty_saved == null ? 0 : players.penalty_saved;
                } else {
                    return players.fa_penalty_saved == null ? 0 : players.fa_penalty_saved;
                }
            },
            goalKeeperSave(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.goalkeeper_save == null ? 0 : players.goalkeeper_save;
                } else {
                    return players.fa_goalkeeper_save == null ? 0 : players.fa_goalkeeper_save;
                }
            },
            total(players) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return players.total == null ? 0 : players.total;
                } else {
                    return players.fa_total == null ? 0 : players.fa_total;
                }
            },
        }
    }
</script>









