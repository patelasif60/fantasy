<template>
    <div class="player-data-container">
        <div class="close-player-data-container">
            <span><a href="javascript:void(0);" @click="hideSquadPlayerDetails"><i class="fas fa-times-circle"></i></a></span>
        </div>
        <div class="player-data-container-slim" v-if="typeof player != 'undefined' && typeof player.position != 'undefined'">

            <div class="player-banner-wrapper">
                <div class="player-banner-img">
                    <div class="player-banner-watermark">
                        <img class="player-banner-watermark-logo" src="/assets/frontend/img/background/player-banner-bg.svg" alt="">
                    </div>
                    <img class="player-crest" :src="player.image" alt="">
                </div>

                <div class="player-banner-body">
                    <div class="player-wrapper-status" v-if="player.status">
                        <span>
                            <img class="lazyload status-img" :src="'/assets/frontend/img/status/' + player.status.status.toLowerCase().split(' ').join('') + '.svg'" alt="">
                        </span>
                        {{player.status.description}} <template v-if="player.status.end_date">until {{player.status.end_date}}</template>
                    </div>

                    <div class="link-nostyle squad-modal-stepper">
                        <div class="squad-modal-content">
                            <div class="squad-modal-label">
                                <div class="badge-area">
                                    <div class="custom-badge custom-badge-xl is-square" :class="playerPosition">{{player.position}}</div>
                                </div>
                            </div>
                            <div class="squad-modal-body">
                                <div class="squad-modal-title text-white">
                                    {{typeof player.first_name != "undefined" && player.first_name != '' && player.first_name != null ? player.first_name[0]+" " : "" }}{{ player.last_name }}

                                </div>
                                <div class="squad-modal-text text-white">{{player.club.name}}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row no-gutters">
                <div class="col-12">
                    <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary m-1 f-12" id="pills-tab-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="History-tab" data-toggle="pill" href="#History" role="tab" aria-controls="History" aria-selected="false">Matches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-1" id="PremierLeague-tab" data-toggle="pill" href="#PremierLeague" role="tab" aria-controls="PremierLeague" aria-selected="true">Season</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="FACup-tab" data-toggle="pill" href="#FACup" role="tab" aria-controls="FACup" aria-selected="false">FA Cup</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link" @click='getPlayerHistoryData' id="playerHistory-tab" data-toggle="pill" href="#playerHistory" role="tab" aria-controls="playerHistory" aria-selected="false">History</a>
                        </li>
                    </ul>
                </div>
            </div>
           
            <!-- <div class="row my-2 no-gutters align-items-center">
                <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                    <label for="position" class="d-block text-center m-0">Seasons</label>
                </div>
                <div class="col-8 col-sm-8 col-md-9 col-lg-10">
                    <div class="season-select2">
                        <select @change="getCurrentPlayerStatsBySeason" v-model="selectedSeason" class="w-75 p-2" id="season-archive-selectbox">
                            <option v-for="(season, id) in seasons" :value='id' :selected="id == selectedSeason">{{season}}</option>
                        </select>
                    </div>
                </div>
            </div> -->
            <div class="row no-gutters">
                <div class="col-12">
                    <div class="tab-content" id="pills-tabContent-1">
                        <div class="tab-pane fade" id="PremierLeague" role="tabpanel" aria-labelledby="PremierLeague-tab">
                             <div class="row">
                                <div class="col-12">
                                    <div class="mx-1">
                                        <div class="form-group">
                                            <label for="season-archive-selectbox">Seasons</label>
                                            <select @change="getCurrentPlayerStatsBySeason" v-model="selectedSeason" class="custom-select js-select2" id="season-archive-selectbox">
                                                <option v-for="(season, id) in seasons" :value='id' :selected="id == selectedSeason">{{season}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-center custom-table mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>PLD</th>
                                            <th>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    GLS
                                                </div>
                                            </th>
                                            <th>
                                              <div class="d-flex justify-content-center align-items-center">
                                                    ASS
                                                </div>
                                            </th>
                                            <th>CS</th>
                                            <th>GA</th>
                                            <th>TOT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-dark">Home</td>
                                            <td>{{ getPLHomePoints('played') }}</td>
                                            <td>{{ getPLHomePoints('goals') }}</td>
                                            <td>{{ getPLHomePoints('assist') }}</td>
                                            <td>{{ getPLHomePoints('cs') }}</td>
                                            <td>{{ getPLHomePoints('ga') }}</td>
                                            <td>{{ getPLHomePoints('total') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark">Away</td>
                                            <td>{{ getPLAwayPoints('played') }}</td>
                                            <td>{{ getPLAwayPoints('goals') }}</td>
                                            <td>{{ getPLAwayPoints('assist') }}</td>
                                            <td>{{ getPLAwayPoints('cs') }}</td>
                                            <td>{{ getPLAwayPoints('ga') }}</td>
                                            <td>{{ getPLAwayPoints('total') }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td>{{ totalPld('premier_league') }}</td>
                                            <td>{{ totalGls('premier_league') }}</td>
                                            <td>{{ totalAsst('premier_league') }}</td>
                                            <td>{{ totalCS('premier_league') }}</td>
                                            <td>{{ totalGA('premier_league') }}</td>
                                            <td>{{ totalPoints('premier_league') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="FACup" role="tabpanel" aria-labelledby="FACup-tab">
                             <div class="row">
                                <div class="col-12">
                                    <div class="mx-1">
                                        <div class="form-group">
                                            <label for="season-archive-selectbox">Seasons</label>
                                            <select @change="getCurrentPlayerStatsBySeason" v-model="selectedSeason" class="custom-select js-select2" id="season-archive-selectbox">
                                                <option v-for="(season, id) in seasons" :value='id' :selected="id == selectedSeason">{{season}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-center custom-table mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>PLD</th>
                                            <th>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    GLS
                                                </div>
                                            </th>
                                            <th>
                                              <div class="d-flex justify-content-center align-items-center">
                                                    ASS
                                                </div>
                                            </th>
                                            <th>CS</th>
                                            <th>GA</th>
                                            <th>TOT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-dark">Home</td>
                                            <td>{{ getFAHomePoints('played') }}</td>
                                            <td>{{ getFAHomePoints('goals') }}</td>
                                            <td>{{ getFAHomePoints('assist') }}</td>
                                            <td>{{ getFAHomePoints('cs') }}</td>
                                            <td>{{ getFAHomePoints('ga') }}</td>
                                            <td>{{ getFAHomePoints('total') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-dark">Away</td>
                                            <td>{{ getFAAwayPoints('played') }}</td>
                                            <td>{{ getFAAwayPoints('goals') }}</td>
                                            <td>{{ getFAAwayPoints('assist') }}</td>
                                            <td>{{ getFAAwayPoints('cs') }}</td>
                                            <td>{{ getFAAwayPoints('ga') }}</td>
                                            <td>{{ getFAAwayPoints('total') }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td>{{ totalPld('fa_cup') }}</td>
                                            <td>{{ totalGls('fa_cup') }}</td>
                                            <td>{{ totalAsst('fa_cup') }}</td>
                                            <td>{{ totalCS('fa_cup') }}</td>
                                            <td>{{ totalGA('fa_cup') }}</td>
                                            <td>{{ totalPoints('fa_cup') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="History" role="tabpanel" aria-labelledby="History-tab">
                             <div class="row">
                                <div class="col-12">
                                    <div class="mx-1">
                                        <div class="form-group">
                                            <label for="season-archive-selectbox">Seasons</label>
                                            <select @change="getCurrentPlayerStatsBySeason" v-model="selectedSeason" class="custom-select js-select2" id="season-archive-selectbox">
                                                <option v-for="(season, id) in seasons" :value='id' :selected="id == selectedSeason">{{season}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive tblResult">
                                <table class="table text-center custom-table mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>DATE</th>
                                            <th>OPP</th>
                                            <th>RES</th>
                                            <th>STATS</th>
                                            <th>TOT</th>
                                            <th>TEAM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="history in player.game_stats.history">
                                            <td>{{history.date}} {{history.time}}</td>
                                            <td>
                                                <i v-if="history.competition == 'FA Cup'" class="far fa-trophy"></i>
                                                {{history.opp}}
                                            </td>
                                            <td>
                                                <span v-if="history.res">
                                                    <span v-if="history.res == 'NA'"></span>
                                                    <span v-else>{{history.res}}</span>
                                                </span>
                                                <span v-else>0</span>
                                            </td>
                                            <td>
                                                <div v-if="history.appearance" class="d-flex justify-content-center align-items-center">
                                                    <span v-if="history.appearance == 'NA'"></span>
                                                    <template v-else>
                                                        <span v-if="history.appearance">
                                                            {{history.appearance}}&nbsp;
                                                        </span>
                                                        <span v-if="history.is_sub == 'in'" class="text-primary font-weight-bold">
                                                            <i class="fas fa-arrow-right"></i>&nbsp;
                                                        </span>
                                                        <span v-if="history.is_sub == 'out'" class="text-danger font-weight-bold">
                                                            <i class="fas fa-arrow-left"></i>&nbsp;
                                                        </span>
                                                        <span v-if="history.goal > 0" class="custom-badge custom-badge-primary is-circle">G</span>&nbsp;
                                                        <span v-if="history.assist > 0" class="custom-badge custom-badge-secondary is-circle">A</span>
                                                        <span v-if="history.red_card > 0" class="has-card">
                                                            <img src="/assets/frontend/img/cta/icon-red-card.svg" draggable="false">&nbsp;
                                                        </span>
                                                        <span v-if="history.yellow_card > 0" class="has-card">
                                                            <img src="/assets/frontend/img/cta/icon-yellow-card.svg" draggable="false">&nbsp;
                                                        </span>
                                                    </template>
                                                </div>
                                                <span v-else>0</span>
                                            </td>
                                            <td>
                                                <template v-if="history.total">
                                                    <span v-if="history.total == 'NA'"></span>
                                                    <span v-else>{{history.total}}</span>
                                                </template>
                                                <span v-else>0</span>
                                            </td>
                                            <td>
                                                <span v-if="history.player_is == 'in_lineup'" class="text-primary"><i class="fas fa-check"></i></span>
                                                <span v-if="history.player_is == 'substitute'" class="text-dark"><i class="fas fa-times"></i></span>
                                                <span v-if="history.player_is == 'not_in_team'" class="text-dark"><i class="fas fa-minus"></i></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="playerHistory" role="tabpanel" aria-labelledby="playerHistory-tab">
                            <div class="table-responsive">
                                <table class="table text-center custom-table mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Season</th>
                                            <th>PLD</th>
                                            <th><div class="d-flex justify-content-center align-items-center"> GLS </div> </th>
                                            <th><div class="d-flex justify-content-center align-items-center">ASS </div> </th>
                                            <th>CS</th>
                                            <th>GA</th>
                                            <th>TOT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="historyPlayer in this.historyPlayerData">
                                            <td>{{historyPlayer.name}}</td>
                                            <td> 
                                                {{ historyPlayer.played }}
                                            </td>
                                            <td> 
                                                {{ historyPlayer.goal}}
                                            </td>
                                            <td> 
                                                {{ historyPlayer.assist }}
                                            </td>
                                            <td> 
                                                {{historyPlayer.clean_sheet}}
                                            </td>
                                            <td> 
                                                {{ historyPlayer.goal_conceded}}
                                            </td>
                                            <td> 
                                                {{ historyPlayer.total}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="player-data-container-slim" v-else>
            <div class="player-banner-wrapper">
                <div class="player-banner-img">
                    <div class="player-banner-watermark">
                        <img class="player-banner-watermark-logo" src="/assets/frontend/img/background/player-banner-bg.svg" alt="">
                    </div>
                    <img class="player-crest" src="https://via.placeholder.com/640x307/333357/333357" alt="">
                </div>
                <div class="player-banner-body">
                    <div class="player-wrapper-status">

                    </div>

                    <div class="link-nostyle lineup-modal-stepper">
                        <div class="lineup-modal-content">
                            <div class="lineup-modal-label">

                            </div>
                            <div class="lineup-modal-body">
                                <div class="lineup-modal-title text-white">Fetching data ...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-12">
                    <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary m-1 f-12" id="pills-tab-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="History-tab" data-toggle="pill" href="#History" role="tab" aria-controls="History" aria-selected="false">Matches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-1" id="PremierLeague-tab" data-toggle="pill" href="#PremierLeague" role="tab" aria-controls="PremierLeague" aria-selected="true">Season</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="FACup-tab" data-toggle="pill" href="#FACup" role="tab" aria-controls="FACup" aria-selected="false">FA Cup</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mx-1">
                        <div class="form-group">
                            <label for="season-archive-selectbox">Seasons</label>
                            <select disabled @change="getCurrentPlayerStatsBySeason" v-model="selectedSeason" class="custom-select" id="season-archive-selectbox">
                            <option v-for="(season, id) in seasons" :value='id' :selected="id == selectedSeason">{{season}}</option>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-12">
                    <div class="tab-content" id="pills-tabContent-1">
                        <div class="tab-pane fade" id="PremierLeague" role="tabpanel" aria-labelledby="PremierLeague-tab">
                        </div>
                        <div class="tab-pane fade" id="FACup" role="tabpanel" aria-labelledby="FACup-tab">
                        </div>
                        <div class="tab-pane fade show active" id="History" role="tabpanel" aria-labelledby="History-tab">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    import { EventBus } from '../../event-bus.js';
    import { EventBus1 } from '../../../event-bus1.js';
    import { Element } from 'element-ui';

    export default {
        props: ['player', 'seasons', 'currentSeason', 'team', 'division'],
        data() {
            return {
                selectedSeason: this.currentSeason,
                selectedPlayerData: this.player,
                currentSelectedTab: '',
                historyPlayerData:[]
                // currentPlayer: this.player.id,
            };
        },
        computed: {
            playerPosition() {
                return "is-" + this.player.position.toLowerCase();
            },
            currentPlayer() {
                return this.player.id;
            },
            selectedPlayer() {
                return this.selectedPlayerData;
            },
            historyTab(){
                let vm = this;
                let data = [];
                let playerD = _.cloneDeep(vm.player.game_stats.history);
                let players = [];
                _.each(playerD, function(selectedPlayer, key){
                    players = _.concat(players, playerD[key])
                })
                return players
            },
            plLeague(){
                let vm = this;
                let tableData = [{
                    home: 'Home',
                    pld: vm.getPLHomePoints('played'),
                    gls: vm.getPLHomePoints('goals'),
                    ass: vm.getPLHomePoints('assist'),
                    cs: vm.getPLHomePoints('cs'),
                    ga: vm.getPLHomePoints('ga'),
                    total: vm.getPLHomePoints('total'),

                  }, {
                    home: 'Away',
                    pld: vm.getPLAwayPoints('played'),
                    gls: vm.getPLAwayPoints('goals'),
                    ass: vm.getPLAwayPoints('assist'),
                    cs: vm.getPLAwayPoints('cs'),
                    ga: vm.getPLAwayPoints('ga'),
                    total: vm.getPLAwayPoints('total'),
                  }, {
                    home: 'Total',
                    pld: vm.totalPld('premier_league'),
                    gls: vm.totalGls('premier_league'),
                    ass: vm.totalAsst('premier_league'),
                    cs: vm.totalCS('premier_league') ,
                    ga: vm.totalGA('premier_league'),
                    total: vm.totalPoints('premier_league'),
                  }]

                return tableData;
            },
            faCup(){
                let vm = this;
                let fatableData = [{
                    home: 'Home',
                    pld: vm.getFAHomePoints('played'),
                    gls: vm.getFAHomePoints('goals'),
                    ass: vm.getFAHomePoints('assist'),
                    cs: vm.getFAHomePoints('cs'),
                    ga: vm.getFAHomePoints('ga'),
                    total: vm.getFAHomePoints('total'),
                 },
                 {
                    home: 'Away',
                    pld: vm.getFAAwayPoints('played'),
                    gls: vm.getFAAwayPoints('goals'),
                    ass: vm.getFAAwayPoints('assist'),
                    cs: vm.getFAAwayPoints('cs'),
                    ga: vm.getFAAwayPoints('ga'),
                    total: vm.getFAAwayPoints('total'),
                 },
                 {
                    home: 'Total',
                    pld: vm.totalPld('fa_cup'),
                    gls: vm.totalGls('fa_cup'),
                    ass: vm.totalAsst('fa_cup'),
                    cs: vm.totalCS('fa_cup') ,
                    ga: vm.totalGA('fa_cup'),
                    total: vm.totalPoints('fa_cup'),
                 }]

                return fatableData;
            }
        },
        mounted() {
            // EventBus1.$on('changeTab', tab => {
            //     this.currentSelectedTab = tab;
            //     if(tab == "facup_prev" || tab == 'facup_total') {
            //         $("#FACup-tab").trigger("click");
            //     } else {
            //         $("#PremierLeague-tab").trigger("click");
            //     }
            // })
        },
        methods: {
            getPLHomePoints: function(pointsFor) {
                let points = 0;
                if(typeof this.player.game_stats.premier_league !== 'undefined' && typeof this.player.game_stats.premier_league.home !== 'undefined')
                {
                    switch(pointsFor) {
                        case "played":
                            points = typeof this.player.game_stats.premier_league.home.pld !== 'undefined' ? this.player.game_stats.premier_league.home.pld : 0;
                            break;
                        case "goals":
                            points = typeof this.player.game_stats.premier_league.home.gls !== 'undefined' ? this.player.game_stats.premier_league.home.gls : 0;
                            break;
                        case "assist":
                            points = typeof this.player.game_stats.premier_league.home.asst !== 'undefined' ? this.player.game_stats.premier_league.home.asst : 0;
                            break;
                        case "cs":
                            points = typeof this.player.game_stats.premier_league.home.cs !== 'undefined' ? this.player.game_stats.premier_league.home.cs : 0;
                            break;
                        case "ga":
                            points = typeof this.player.game_stats.premier_league.home.ga !== 'undefined' ? this.player.game_stats.premier_league.home.ga : 0;
                            break;
                        case "total":
                            points = typeof this.player.game_stats.premier_league.home.total !== 'undefined' ? this.player.game_stats.premier_league.home.total : 0;
                            break;
                    }
                }
                return parseInt(points);
            },

            getPLAwayPoints: function(pointsFor) {
                let points = 0;
                if(typeof this.player.game_stats.premier_league !== 'undefined' && typeof this.player.game_stats.premier_league.away !== 'undefined')
                {
                    switch(pointsFor) {
                        case "played":
                            points = typeof this.player.game_stats.premier_league.away.pld !== 'undefined' ? this.player.game_stats.premier_league.away.pld : 0;
                            break;
                        case "goals":
                            points = typeof this.player.game_stats.premier_league.away.gls !== 'undefined' ? this.player.game_stats.premier_league.away.gls : 0;
                            break;
                        case "assist":
                            points = typeof this.player.game_stats.premier_league.away.asst !== 'undefined' ? this.player.game_stats.premier_league.away.asst : 0;
                            break;
                        case "cs":
                            points = typeof this.player.game_stats.premier_league.away.cs !== 'undefined' ? this.player.game_stats.premier_league.away.cs : 0;
                            break;
                        case "ga":
                            points = typeof this.player.game_stats.premier_league.away.ga !== 'undefined' ? this.player.game_stats.premier_league.away.ga : 0;
                            break;
                        case "total":
                            points = typeof this.player.game_stats.premier_league.away.total !== 'undefined' ? this.player.game_stats.premier_league.away.total : 0;
                            break;
                    }
                }
                return parseInt(points);
            },

            getFAHomePoints: function(pointsFor) {
                let points = 0;
                if(typeof this.player.game_stats.fa_cup !== 'undefined' && typeof this.player.game_stats.fa_cup.home !== 'undefined')
                {
                    switch(pointsFor) {
                        case "played":
                            points = typeof this.player.game_stats.fa_cup.home.pld !== 'undefined' ? this.player.game_stats.fa_cup.home.pld : 0;
                            break;
                        case "goals":
                            points = typeof this.player.game_stats.fa_cup.home.gls !== 'undefined' ? this.player.game_stats.fa_cup.home.gls : 0;
                            break;
                        case "assist":
                            points = typeof this.player.game_stats.fa_cup.home.asst !== 'undefined' ? this.player.game_stats.fa_cup.home.asst : 0;
                            break;
                        case "cs":
                            points = typeof this.player.game_stats.fa_cup.home.cs !== 'undefined' ? this.player.game_stats.fa_cup.home.cs : 0;
                            break;
                        case "ga":
                            points = typeof this.player.game_stats.fa_cup.home.ga !== 'undefined' ? this.player.game_stats.fa_cup.home.ga : 0;
                            break;
                        case "total":
                            points = typeof this.player.game_stats.fa_cup.home.total !== 'undefined' ? this.player.game_stats.fa_cup.home.total : 0;
                            break;
                    }
                }
                return parseInt(points);
            },

            getFAAwayPoints: function(pointsFor) {
                let points = 0;
                if(typeof this.player.game_stats.fa_cup !== 'undefined' && typeof this.player.game_stats.fa_cup.away !== 'undefined')
                {
                    switch(pointsFor) {
                        case "played":
                            points = typeof this.player.game_stats.fa_cup.away.pld !== 'undefined' ? this.player.game_stats.fa_cup.away.pld : 0;
                            break;
                        case "goals":
                            points = typeof this.player.game_stats.fa_cup.away.gls !== 'undefined' ? this.player.game_stats.fa_cup.away.gls : 0;
                            break;
                        case "assist":
                            points = typeof this.player.game_stats.fa_cup.away.asst !== 'undefined' ? this.player.game_stats.fa_cup.away.asst : 0;
                            break;
                        case "cs":
                            points = typeof this.player.game_stats.fa_cup.away.cs !== 'undefined' ? this.player.game_stats.fa_cup.away.cs : 0;
                            break;
                        case "ga":
                            points = typeof this.player.game_stats.fa_cup.away.ga !== 'undefined' ? this.player.game_stats.fa_cup.away.ga : 0;
                            break;
                        case "total":
                            points = typeof this.player.game_stats.fa_cup.away.total !== 'undefined' ? this.player.game_stats.fa_cup.away.total : 0;
                            break;
                    }
                }
                return parseInt(points);
            },
            getPlayerHistoryData: function() {
                this.axios.get(route('manage.team.player.history', {division: this.division,player_id: this.player.id}))
                .then((response) => {
                    if(_.isEmpty(response.data))
                    {
                        $('.js-player-history').addClass('d-none');
                    }  
                    else
                    {
                       $('.js-player-history').removeClass('d-none');
                       this.historyPlayerData = response.data;
                    }
                
                })
                .catch((error) => {
                    console.log(error);
                });
            },

            totalPld(competition)
            {
                let home = 0;
                let away = 0;
                if(competition == 'premier_league') {
                    home = this.getPLHomePoints('played');
                    away = this.getPLAwayPoints('played');
                } else {
                    home = this.getFAHomePoints('played');
                    away = this.getFAAwayPoints('played');
                }
                return home + away;
            },

            totalGls(competition)
            {
                let home = 0;
                let away = 0;
                if(competition == 'premier_league') {
                    home = this.getPLHomePoints('goals');
                    away = this.getPLAwayPoints('goals');
                } else {
                    home = this.getFAHomePoints('goals');
                    away = this.getFAAwayPoints('goals');
                }
                return home + away;
            },

            totalAsst(competition)
            {
                let home = 0;
                let away = 0;
                if(competition == 'premier_league') {
                    home = this.getPLHomePoints('assist');
                    away = this.getPLAwayPoints('assist');
                } else {
                    home = this.getFAHomePoints('assist');
                    away = this.getFAAwayPoints('assist');
                }
                return home + away;
            },

            totalCS(competition)
            {
                let home = 0;
                let away = 0;
                if(competition == 'premier_league') {
                    home = this.getPLHomePoints('cs');
                    away = this.getPLAwayPoints('cs');
                } else {
                    home = this.getFAHomePoints('cs');
                    away = this.getFAAwayPoints('cs');
                }
                return home + away;
            },

            totalGA(competition)
            {
                let home = 0;
                let away = 0;
                if(competition == 'premier_league') {
                    home = this.getPLHomePoints('ga');
                    away = this.getPLAwayPoints('ga');
                } else {
                    home = this.getFAHomePoints('ga');
                    away = this.getFAAwayPoints('ga');
                }
                return home + away;
            },

            totalPoints(competition)
            {
                let home = 0;
                let away = 0;
                if(competition == 'premier_league') {
                    home = this.getPLHomePoints('total');
                    away = this.getPLAwayPoints('total');
                } else {
                    home = this.getFAHomePoints('total');
                    away = this.getFAAwayPoints('total');
                }
                return home + away;
            },

            historyTabClicked()
            {
                this.slimScroll();
            },

            hideSquadPlayerDetails()
            {
                this.$emit('hideSquadPlayerDetails');
            },

            getCurrentPlayerStatsBySeason()
            {
                this.axios.get(route('player.stats.by.season', {division: this.division, team: this.team, player: this.currentPlayer, season: this.selectedSeason}))
                    .then((response) => {

                        this.$emit('displayPlayerStats', [response.data[this.currentPlayer], this.selectedSeason]);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>
