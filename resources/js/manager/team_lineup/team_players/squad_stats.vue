<template>
    <div class="table-responsive">
        <table class="table custom-table table-hover m-0 fixed-column">
            <thead class="thead-dark">
                <tr>
                    <th>PLAYER
                        <template v-if="isMobileScreen()">
                            <template v-if="showMore"> &nbsp;
                                <span @click="showMore = !showMore" style="cursor:pointer; white-space: nowrap;" class="text-danger">
                                    <i class="fas fa-chevron-left"></i> Back
                                </span>
                            </template>
                        </template>
                    </th>
                    <template v-if="showMore">
                        <th class="text-center">PLD</th>
                        <th class="text-center">GLS</th>
                        <th class="text-center">ASS</th>
                        <th class="text-center">CS</th>
                        <th class="text-center">GA</th>
                        <template v-if="showAdditionalColumns()">
                            <th class="text-center" v-if="columns.club_win > 0">CW</th>
                            <th class="text-center" v-if="columns.yellow_card > 0">YC</th>
                            <th class="text-center" v-if="columns.red_card > 0">RC</th>
                            <th class="text-center" v-if="columns.own_goal > 0">OG</th>
                            <th class="text-center" v-if="columns.penalty_missed > 0">PM</th>
                            <th class="text-center" v-if="columns.penalty_save > 0">PS</th>
                            <th class="text-center" v-if="columns.goalkeeper_save_x5 > 0">GS</th>
                        </template>
                    </template>
                    <template v-if="!showMore">
                        <th class="text-center" v-if="!isMobileScreen()">£M</th>
                        <th class="text-center" v-if="currentTab == 'current_week' || currentTab == 'week_total'">WK</th>
                        <th class="text-center" v-else>RND</th>
                        <template v-if="currentTab == 'current_week' || currentTab == 'week_total'">
                            <th class="text-center" v-if="!isMobileScreen()">mth</th>
                        </template>
                    </template>
                    <th class="text-center">TOT
                        <template v-if="!isMobileScreen()">
                            <template v-if="showMore"> &nbsp;
                                <span @click="showMore = !showMore" style="cursor:pointer; white-space: nowrap;" class="text-danger">
                                    <i class="fas fa-chevron-left"></i> Back
                                </span>
                            </template>
                        </template>
                    </th>
                    <template v-if="!showMore">
                        <th class="text-center">Next fixture</th>
                        <th class="text-center">
                            <span style="cursor:pointer; white-space: nowrap;" class="text-danger" @click="showMore = !showMore"> More <i class="fas fa-chevron-right"></i>
                            </span>
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <template v-for="players in activePlayers">
                    <tr v-for="player in players">
                        <td class="position">
                            <div class="player-wrapper">
                                <span class="custom-badge custom-badge-lg is-gk" :class="playerPosition(player)">{{player.position}}</span>
                                <div>
                                    <a href="javascript:void(0);" class="team-name link-nostyle text-capitalize" @click="displaySquadPlayerDetails (player.player_id)">
                                    {{typeof player.player_first_name != "undefined" && player.player_first_name != '' && player.player_first_name != null ? player.player_first_name[0]+" " : "" }}{{ player.player_last_name }} <small>{{ player.short_code }}</small></a>
                                </div>
                            </div>
                        </td>
                        <template v-if="showMore">
                            <td class="text-center">{{played(player)}}</td>
                            <td class="text-center">{{goals(player)}}</td>
                            <td class="text-center">{{assist(player)}}</td>
                            <td class="text-center">{{clean_sheet(player)}}</td>
                            <td class="text-center">{{goals_against(player)}}</td>
                            <template v-if="showAdditionalColumns()">
                                <td class="text-center" v-if="columns.club_win > 0">{{club_win(player)}}</td>
                                <td class="text-center" v-if="columns.yellow_card > 0">{{yellow_card(player)}}</td>
                                <td class="text-center" v-if="columns.red_card > 0">{{red_card(player)}}</td>
                                <td class="text-center" v-if="columns.own_goal > 0">{{own_goals(player)}}</td>
                                <td class="text-center" v-if="columns.penalty_missed > 0">{{penalties_missed(player)}}</td>
                                <td class="text-center" v-if="columns.penalty_save > 0">{{penalties_saved(player)}}</td>
                                <td class="text-center" v-if="columns.goalkeeper_save_x5 > 0">{{goalkeeper_saves(player)}}</td>
                            </template>
                        </template>
                        <template v-if="!showMore">
                            <td class="text-center" v-if="!isMobileScreen()">{{transfer_value(player)}}</td>
                            <td class="text-center">{{weekPoint(player)}}</td>
                            <template v-if="currentTab == 'current_week' || currentTab == 'week_total'">
                                <td class="text-center" v-if="!isMobileScreen()">{{player.month_total2}}</td>
                            </template>
                        </template>
                        <template v-if="isMobileScreen()">
                            <td class="text-center">{{totalPoint(player)}}</td>
                        </template>
                        <template v-else>
                            <td :class="showMore ? 'pl-4': 'text-center'">{{totalPoint(player)}}</td>
                        </template>
                        <template v-if="!showMore">
                            <td class="text-center">
                                <a href="javascript:void(0);" class="team-name link-nostyle">{{nextFixtureOpponent(player)}}</a>
                                <a href="javascript:void(0);" class="player-name link-nostyle small">{{nextFixtureDtTime(player)}}</a>
                            </td>
                            <td class="text-center">
                                <span v-if="nextFixtureLineup(player) == 'in'" class="text-primary"><i class="fas fa-check"></i></span>
                                <span v-if="nextFixtureLineup(player) == 'out'" class="text-dark"><i class="fas fa-times"></i></span>
                            </td>
                        </template>
                    </tr>
                </template>
            </tbody>
<!--         </table>
        <table class="table custom-table table-hover m-0 fixed-column"> -->
            <thead class="thead-dark">
                <tr>
                    <th>PLAYER
                        <template v-if="isMobileScreen()">
                            <template v-if="showMore"> &nbsp;
                                <span @click="showMore = !showMore" style="cursor:pointer; white-space: nowrap;" class="text-danger">
                                    <i class="fas fa-chevron-left"></i> Back
                                </span>
                            </template>
                        </template>
                    </th>
                    <template v-if="showMore">
                        <th class="text-center">PLD</th>
                        <th class="text-center">GLS</th>
                        <th class="text-center">ASS</th>
                        <th class="text-center">CS</th>
                        <th class="text-center">GA</th>
                        <template v-if="showAdditionalColumns()">
                            <th class="text-center" v-if="columns.club_win > 0">CW</th>
                            <th class="text-center" v-if="columns.yellow_card > 0">YC</th>
                            <th class="text-center" v-if="columns.red_card > 0">RC</th>
                            <th class="text-center" v-if="columns.own_goal > 0">OG</th>
                            <th class="text-center" v-if="columns.penalty_missed > 0">PM</th>
                            <th class="text-center" v-if="columns.penalty_save > 0">PS</th>
                            <th class="text-center" v-if="columns.goalkeeper_save_x5 > 0">GS</th>
                        </template>
                    </template>
                    <template v-if="!showMore">
                        <th class="text-center" v-if="!isMobileScreen()">£M</th>
                        <th class="text-center" v-if="currentTab == 'current_week' || currentTab == 'week_total'">WK</th>
                        <th class="text-center" v-else>RND</th>
                        <template v-if="currentTab == 'current_week' || currentTab == 'week_total'">
                            <th class="text-center" v-if="!isMobileScreen()">mth</th>
                        </template>
                    </template>
                    <th class="text-center">TOT
                        <template v-if="!isMobileScreen()">
                            <template v-if="showMore"> &nbsp;
                                <span @click="showMore = !showMore" style="cursor:pointer; white-space: nowrap;" class="text-danger">
                                    <i class="fas fa-chevron-left"></i> Back
                                </span>
                            </template>
                        </template>
                    </th>
                    <template v-if="!showMore">
                        <th class="text-center">Next fixture</th>
                        <th class="text-center">
                            <span style="cursor:pointer; white-space: nowrap;" class="text-danger" @click="showMore = !showMore"> More <i class="fas fa-chevron-right"></i>
                            </span>
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <tr v-for="player in subPlayers">
                    <td class="position">
                        <div class="player-wrapper">
                            <span class="custom-badge custom-badge-lg is-gk" :class="playerPosition(player)">{{player.position}}</span>
                            <div>
                                <a href="javascript:void(0);" class="team-name link-nostyle text-capitalize" @click="displaySquadPlayerDetails (player.player_id)">
                                {{typeof player.player_first_name != "undefined" && player.player_first_name != '' && player.player_first_name != null ? player.player_first_name[0]+" " : "" }}{{ player.player_last_name }} <small>{{ player.short_code }}</small></a>
                            </div>
                        </div>
                    </td>
                    <template v-if="showMore">
                        <td class="text-center">{{played(player)}}</td>
                        <td class="text-center">{{goals(player)}}</td>
                        <td class="text-center">{{assist(player)}}</td>
                        <td class="text-center">{{clean_sheet(player)}}</td>
                        <td class="text-center">{{goals_against(player)}}</td>
                        <template v-if="showAdditionalColumns()">
                            <td class="text-center" v-if="columns.club_win > 0">{{club_win(player)}}</td>
                            <td class="text-center" v-if="columns.yellow_card > 0">{{yellow_card(player)}}</td>
                            <td class="text-center" v-if="columns.red_card > 0">{{red_card(player)}}</td>
                            <td class="text-center" v-if="columns.own_goal > 0">{{own_goals(player)}}</td>
                            <td class="text-center" v-if="columns.penalty_missed > 0">{{penalties_missed(player)}}</td>
                            <td class="text-center" v-if="columns.penalty_save > 0">{{penalties_saved(player)}}</td>
                            <td class="text-center" v-if="columns.goalkeeper_save_x5 > 0">{{goalkeeper_saves(player)}}</td>
                        </template>
                    </template>
                    <template v-if="!showMore">
                        <td class="text-center" v-if="!isMobileScreen()">{{transfer_value(player)}}</td>
                        <td class="text-center">{{weekPoint(player)}}</td>
                        <template v-if="currentTab == 'current_week' || currentTab == 'week_total'">
                            <td class="text-center" v-if="!isMobileScreen()">{{player.month_total2}}</td>
                        </template>
                    </template>
                    <template v-if="isMobileScreen()">
                        <td class="text-center">{{totalPoint(player)}}</td>
                    </template>
                    <template v-else>
                        <td :class="showMore ? 'pl-4': 'text-center'">{{totalPoint(player)}}</td>
                    </template>
                    <template v-if="!showMore">
                        <td class="text-center">
                            <a href="javascript:void(0);" class="team-name link-nostyle">{{nextFixtureOpponent(player)}}</a>
                            <a href="javascript:void(0);" class="player-name link-nostyle small">{{nextFixtureDtTime(player)}}</a>
                        </td>
                        <td class="text-center">
                            <span v-if="nextFixtureLineup(player) == 'in'" class="text-primary"><i class="fas fa-check"></i></span>
                            <span v-if="nextFixtureLineup(player) == 'out'" class="text-dark"><i class="fas fa-times"></i></span>
                        </td>
                    </template>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        components: {
        },
        props: ['activePlayers', 'playerSeasonStats', 'subPlayers', 'currentTab', 'division', 'team', 'columns'],
        data() {
            return {
                showMore: false,
            };
        },
        mounted() {
            setTimeout(function() {
                if ($(window).width() > 991) {
                    let ContentHeight = $('.js-left-pitch-area').height();
                    $(function(){
                        $(function(){
                            $('.player-data').height(ContentHeight);
                        });
                    });
                }
            }, 3000);
        },
        computed: {
            squadActivePlayer() {
                let data = [];
                let activePlayers = _.cloneDeep(this.activePlayers);
                let allPlayers = [];
                _.each(activePlayers, function(player, key){
                     allPlayers = _.concat(allPlayers, activePlayers[key]);
                });

                return allPlayers;
            },
            squadSubPlayers() {
                let subData = [];
                let subPlayers = _.cloneDeep(this.subPlayers);
                let subPlayer = [];
                _.each(subPlayers, function(player, key){
                    subPlayer = _.concat(subPlayer, subPlayers[key]);
                })

                return subPlayer;
            },
        },
        methods: {
            showAdditionalColumns() {
                let result = 0;
                if(typeof(this.columns.club_win) != 'undefined')
                    result = result + this.columns.club_win;
                if(typeof(this.columns.yellow_card) != 'undefined')
                    result = result + this.columns.yellow_card;
                if(typeof(this.columns.red_card) != 'undefined')
                    result = result + this.columns.red_card;
                if(typeof(this.columns.own_goal) != 'undefined')
                    result = result + this.columns.own_goal;
                if(typeof(this.columns.penalties_missed) != 'undefined')
                    result = result + this.columns.penalties_missed;
                if(typeof(this.columns.penalty_save) != 'undefined')
                    result = result + this.columns.penalty_save;
                if(typeof(this.columns.goalkeeper_save_x5) != 'undefined')
                    result = result + this.columns.goalkeeper_save_x5;

                if(result > 0)
                    return true;
                else
                    return false;
            },
            displaySquadPlayerDetails(player_id) {
                this.$emit('displaySquadPlayerDetails', player_id);
            },
            playerPosition(player) {
                return "is-"+player.position.toLowerCase();
            },
            player_name(player) {
                if(player.player_first_name != null)
                    return player.player_first_name.split('')[0] + " " + player.player_last_name;
                else
                    return player.player_last_name;
            },
            transfer_value(player) {
                return player.transfer_value == null ? "0.00" : player.transfer_value;
            },
            points(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    //return player['week_total'].total == null ? 0 : player['week_total'].total;
                    return player.month_total2;
                } else {
                    return player['facup_total'].total == null ? 0 : player['facup_total'].total;
                }
                // return player[this.currentTab].total == null ? 0 : player[this.currentTab].total;
            },
            played(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].pld == null ? 0 : player['week_total'].pld;
                } else {
                    return player['facup_total'].pld == null ? 0 : player['facup_total'].pld;
                }
                // return player[this.currentTab].pld == null ? 0 : player[this.currentTab].pld;
            },
            goals(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].gls == null ? 0 : player['week_total'].gls;
                } else {
                    return player['facup_total'].gls == null ? 0 : player['facup_total'].gls;
                }
                // return player[this.currentTab].gls == null ? 0 : player[this.currentTab].gls;
            },
            assist(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].asst == null ? 0 : player['week_total'].asst;
                } else {
                    return player['facup_total'].asst == null ? 0 : player['facup_total'].asst;
                }
                // return player[this.currentTab].asst == null ? 0 : player[this.currentTab].asst;
            },
            clean_sheet(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].cs == null ? 0 : player['week_total'].cs;
                } else {
                    return player['facup_total'].cs == null ? 0 : player['facup_total'].cs;
                }
                // return player[this.currentTab].cs == null ? 0 : player[this.currentTab].cs;
            },
            goals_against(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].ga == null ? 0 : player['week_total'].ga;
                } else {
                    return player['facup_total'].ga == null ? 0 : player['facup_total'].ga;
                }
                // return player[this.currentTab].ga == null ? 0 : player[this.currentTab].ga;
            },

            club_win(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].cw == null ? 0 : player['week_total'].cw;
                } else {
                    return player['facup_total'].cw == null ? 0 : player['facup_total'].cw;
                }
            },
            yellow_card(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].yc == null ? 0 : player['week_total'].yc;
                } else {
                    return player['facup_total'].yc == null ? 0 : player['facup_total'].yc;
                }
            },
            red_card(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].rc == null ? 0 : player['week_total'].rc;
                } else {
                    return player['facup_total'].rc == null ? 0 : player['facup_total'].rc;
                }
            },
            own_goals(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].og == null ? 0 : player['week_total'].og;
                } else {
                    return player['facup_total'].og == null ? 0 : player['facup_total'].og;
                }
            },
            penalties_missed(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].pm == null ? 0 : player['week_total'].pm;
                } else {
                    return player['facup_total'].pm == null ? 0 : player['facup_total'].pm;
                }
            },
            penalties_saved(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].ps == null ? 0 : player['week_total'].ps;
                } else {
                    return player['facup_total'].ps == null ? 0 : player['facup_total'].ps;
                }
            },
            goalkeeper_saves(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player['week_total'].gs == null ? 0 : player['week_total'].gs;
                } else {
                    return player['facup_total'].gs == null ? 0 : player['facup_total'].gs;
                }
            },

            nextFixtureOpponent(player) {
                var fixture = '';
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    fixture = player.next_fixture['PL'];
                } else {
                    fixture = player.next_fixture['FA'];
                }

                if(typeof(fixture.short_code) != 'undefined' && fixture.short_code != 'undefined') {
                    if(fixture.type == 'H') {
                        return fixture.short_code + " (h)";
                    } else {
                        return fixture.short_code + " (a)";
                    }
                } else {
                    return '-'
                }
            },
            nextFixtureDtTime(player) {
                var fixture = '';
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    fixture = player.next_fixture['PL'];
                } else {
                    fixture = player.next_fixture['FA'];
                }

                if(typeof(fixture.str_date) != 'undefined' && fixture.str_date != 'undefined') {
                    return fixture.str_date + " " + fixture.time;
                }
            },
            nextFixtureLineup(player) {
                var fixture = '';
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    fixture = player.next_fixture['PL'];
                } else {
                    fixture = player.next_fixture['FA'];
                }
                if(typeof(fixture.in_lineup) != 'undefined') {
                    return fixture.in_lineup;
                }
            },
            weekPoint(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player.current_week.total ? player.current_week.total : 0;
                } else {
                    return player.facup_prev.total ? player.facup_prev.total : 0;
                   // return player.week_total2_FA > 0 ? player.week_total2_FA : 0;
                }
            },
            totalPoint(player) {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    return player.total ? player.total : 0;
                } else {
                    return player.facup_total.total ? player.facup_total.total : 0;
                }
            },
            goToMoreScreen() {
                if(this.currentTab == 'current_week' || this.currentTab == 'week_total') {
                    window.location = route('manage.team.lineup.more', {'division': this.division.id, 'team': this.team, 'competition': 'pl'});
                } else {
                    window.location = route('manage.team.lineup.more', {'division': this.division.id, 'team': this.team, 'competition': 'fa'});
                }
            }
        }
    }
</script>
