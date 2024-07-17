<template>
	<div>
        <p>It’s your turn to nominate a player. Once you have nominated a player, bidding will begin with the managers in the room.</p>

        <div class="d-flex justify-content-between align-items-center">
            <p class="font-weight-bold">Time remaining</p>
            <p class="bg-primary px-2 small">{{ secondsForRM }} seconds</p>
        </div>

        <div class="row gutters-md">
            <div class="col-6">
                <div class="form-group">
                    <label for="position">Position</label>
                    <select class="js-player-position-select2 custom-select p-2 w-100" id="position" v-model="selectedPosition" @change="getPlayers">
                        <option v-for="(position, index) in positions" :value="index">{{index}}</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="club">Club</label>
                    <select class="js-club-select2 custom-select p-2 w-100" id="club" v-model="selectedClub" @change="getPlayers">
                        <option value="">All</option>
                        <option v-for="(club, index) in clubs" :value="index">{{club}}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="player-name">Player Name</label>
            <input type="text" class="form-control" id="player-name" name="player-name" placeholder="e.g Harry Kane" v-model="search">
        </div>

        <div class="table-responsive">
            <table class="table custom-table auction-table m-0">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-uppercase">player</th>
                        <th class="text-center text-uppercase">pld</th>
                        <th class="text-center text-uppercase">gls</th>
                        <th class="text-center text-uppercase">ass</th>
                        <th class="text-center text-uppercase">cs</th>
                        <th class="text-center text-uppercase">ga</th>
                        <th class="text-center text-uppercase">tot</th>
                        
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="player in filteredPlayers">
                        <td>
                            <div class="player-wrapper">
                                <span class="custom-badge custom-badge-lg is-square" :class="'is-' + player.position.toLowerCase().trim()">{{player.position}}</span>

                                <div>
                                    <a href="#" class="team-name link-nostyle">{{player.player_first_name}} {{player.player_last_name}}</a>
                                    <br>
                                    <a href="#" class="player-name link-nostyle small">{{player.club_name}}</a>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{player.total_game_played}}</td>
                        <td class="text-center">{{player.total_goal}}</td>
                        <td class="text-center">{{player.total_assist}}</td>
                        <td class="text-center">{{player.total_clean_sheet}}</td>
                        <td class="text-center">{{player.total_goal_against}}</td>
                        <td class="text-center">{{player.total}}</td>
                        <td class="text-center">
                            <template v-if='isPlayerSold(player.id)'>
                                <span v-html='isPlayerSold(player.id)'></span>
                            </template>
                            <template v-else>
                                <div v-if="player.available == true">
                                    <div class="quota-player"><span class="text-muted text-uppercase" style="cursor: pointer"><i class="fas fa-pound-sign"  @click="setPlayer(player)"></i></span></div>
                                </div>
                                <div v-else>
                                    <div v-if="player.club_quota == 'exosted'">
                                        Quota
                                    </div>
                                    <div class="quota-player" v-else>
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 mb-2"><button type="submit" class="btn btn-primary btn-block">Pass</button></div>

        <!-- Modal -->
        <div class="modal fade" id="bid-modal" tabindex="-1" role="dialog" aria-labelledby="bid-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="player-bid-modal-body">
                            <form @submit.prevent="onSubmitRemoteBid" name="stepform2">
                                <div class="player-bid-modal-content">
                                    <div class="player-bid-modal-label">
                                        <div class="custom-badge custom-badge-xl is-square" :class="'is-' + form.position.toLowerCase().trim()">{{form.position}}</div>
                                    </div>
                                    <div class="player-bid-modal-body">
                                        <div class="player-bid-modal-title">{{form.player}}</div>
                                        <div class="player-bid-modal-text">{{form.club}}</div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="bid-amount" class="text-body">Enter bid amount (&euro;m)</label>
                                    <!-- <input type="text" class="form-control" id="bid-amount" placeholder="e.g 15" v-model="form.opening_bid"> -->
                                    <input type="text" class="form-control" id="opening_bid" name="opening_bid" placeholder="35.5" v-model="form.opening_bid" v-validate="'required|decimal:3|teamBudget'" :class="{ 'is-invalid': submitted && errors.has('opening_bid') }"
                                        autocomplete="off">

                                    <div v-if="submitted && errors.has('opening_bid')" class="invalid-feedback d-block">{{errors.first('opening_bid')}}</div>
                                </div>

                                <div class="custom-alert alert-tertiary" v-if="errorFlag">
                                    <div class="alert-icon">
                                        <img src="/assets/frontend/img/cta/icon-whistle.svg" alt="alert-img">
                                    </div>
                                    <div class="alert-text text-body">
                                        {{ errorMessage }}
                                    </div>
                                </div>

                                <div class="row gutters-sm">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary btn-block">Ok</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>

<script>
    import VeeValidate from "vee-validate";
    Vue.use(VeeValidate);
    var moment = require('moment');
    
	export default {
		props: ['clubs', 'positions', 'players', 'division', 'teamDetails', 'maxClubPlayers', 'squadSize'],
		data() {
			return {
                submitted: false,
				selectedPosition: 'Goalkeeper (GK)',
				selectedClub: '',
				auctionPlayers: {},
                search: '',
                secondsForRM: 0,
                timestampForRM: '',
                form: {
                    player_first_name: '',
                    player_last_name: '',
                    player: '',
                    player_id: '',
                    opening_bid: '',
                    opening_bid_manager_id: this.teamDetails.manager_id,
                    opening_bid_manager_name: '',
                    round: 1,
                    position: '',
                    club: '',
                    club_short_code: '',
                    club_id: ''
                },
                formSubmitted: false,
                nominateRMPlayerTimestamp: '',
                setIntervalSet: false,
                errorMessages: {
                    en: {
                        custom: {
                            opening_bid: {
                                required: 'This field must be numeric and may contain 3 decimal points.',
                                decimal: 'This field must be numeric and may contain 3 decimal points.',
                                teamBudget: 'Team budget is lower than bid amount'
                            }                        
                        }
                    }
                },
                errorFlag: false,
                errorMessage: '',
                currentManager: []
			}
		},
		mounted() {
            this.$store.dispatch('setCurrentPlayerAuctionData')
            this.$validator.localize(this.errorMessages);

            this.timestampForRM = this.$store.getters.defaultBidTime;
            this.$store.dispatch('getCurrentTimestamp')

            let manager = _.head(_.filter(this.$store.getters.teamManagers, [ 'manager_id', parseInt(this.teamDetails.manager_id) ]));
            this.currentManager = manager;
            this.form.opening_bid_manager_name = manager.first_name+" "+manager.last_name;
                        
			this.auctionPlayers = _.cloneDeep(this.players);


            var vm = this;
            setTimeout(function() {
                vm.timestampForRM = vm.$store.getters.currentTimestamp;
                var now  = moment.unix(vm.$store.getters.currentTimestamp).format("DD/MM/YYYY HH:mm:ss");

                var then = moment.unix(vm.$store.getters.nominateRMPlayerTimestamp).format("DD/MM/YYYY HH:mm:ss");

                vm.secondsForRM = moment(then,"DD/MM/YYYY HH:mm:ss").diff(moment(now,"DD/MM/YYYY HH:mm:ss"), 'seconds')
                vm.nominateRMPlayerTimestamp = vm.secondsForRM

                if(vm.secondsForRM > 0) {
                    vm.interval = setInterval(() => {
                      vm.updateSecondsForRM();
                    }, 1000);
                } else {
                    vm.secondsForRM = 0;
                }

                vm.intervalData = setInterval(() => {
                  vm.updateNominateRMPlayerTimestamp();
                }, 1000);
            }, 200);

            this.$validator.extend('teamBudget', (value) => {

                var manager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', parseInt(this.teamDetails.manager_id) ]));
                if(typeof manager.team_budget == "undefined") {
                    return false
                }
                return manager.team_budget > value;
            }, {
                hasTarget: true
            });

            this.getPlayers()
		},
        watch: {
            nominateRMPlayerTimestamp() {
                if(this.nominateRMPlayerTimestamp < 0) {
                    this.$store.dispatch('getCurrentTimestamp')

                    var now  = moment.unix(this.$store.getters.currentTimestamp).format("DD/MM/YYYY HH:mm:ss");
                    var then = moment.unix(this.$store.getters.nominateRMPlayerTimestamp).format("DD/MM/YYYY HH:mm:ss");
                    this.nominateRMPlayerTimestamp = moment(then,"DD/MM/YYYY HH:mm:ss").diff(moment(now,"DD/MM/YYYY HH:mm:ss"), 'seconds')

                    this.setIntervalSet = false;
                }

                if(this.nominateRMPlayerTimestamp >= 0) {
                    this.$store.dispatch('getCurrentTimestamp')
                    this.timestampForRM = this.$store.getters.currentTimestamp;
                    var now  = moment.unix(this.$store.getters.currentTimestamp).format("DD/MM/YYYY HH:mm:ss");

                    var then = moment.unix(this.$store.getters.nominateRMPlayerTimestamp).format("DD/MM/YYYY HH:mm:ss");

                    this.secondsForRM = moment(then,"DD/MM/YYYY HH:mm:ss").diff(moment(now,"DD/MM/YYYY HH:mm:ss"), 'seconds')

                    this.nominateRMPlayerTimestamp = this.secondsForRM;

                    if(!this.setIntervalSet) {
                        this.formSubmitted = false;
                        if(this.secondsForRM > 0) {
                            this.interval1 = setInterval(() => {
                              this.updateSecondsForRMNew();
                            }, 1000);
                        } else {
                            this.secondsForRM = 0;
                        }
                    }

                    this.setIntervalSet = true;
                }
            },
        },
        computed: {
            filteredPlayers: function(event) {
                let vm = this;
                return _.filter(this.auctionPlayers, function(player)
                {
                    return player.player_first_name.toLowerCase().match(vm.search.toLowerCase()) || player.player_last_name.toLowerCase().match(vm.search.toLowerCase());
                });
            },
        },
		methods: {

            isPlayerSold: function(player_id) {
                var playerData = _.head(_.filter(this.$store.getters.soldPlayers, [ 'player_id', parseInt(player_id) ]))
                if(playerData) {
                    var manager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', parseInt(playerData.high_bidder_id) ]));
                    if(manager.manager_id == this.teamDetails.manager_id) {
                        return '<i class="fas fa-check text-primary"></i><br>£' + playerData.high_bid_value + 'm'
                    } else {
                        return manager.team_name + '<br>£' + playerData.high_bid_value + 'm'
                    }
                } else {
                    return false;
                }
            },

            filterPlayers(player) {
                return player.player_first_name.match(this.search);
            },

			getPlayers() {
                axios.get(route('manage.live.online.auction.players', {'division': this.division, 'position': this.selectedPosition, 'club': this.selectedClub}))
                    .then((response) => {
                        this.auctionPlayers = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
			},

            setPlayer(player) {
                if(this.secondsForRM > 0) {
                    this.form.opening_bid = '';
                    this.form.player = player.player_first_name + ' ' + player.player_last_name + " ("+ player.shortCode +") " + player.position;
                    this.form.club = player.club_name;
                    this.form.position = player.position;
                    this.form.player_id = player.id;
                    
                    this.form.player_first_name = player.player_first_name;
                    this.form.player_last_name = player.player_last_name;
                    this.form.club_short_code = player.short_code;
                    this.form.club_id = player.club_id;

                    $('#bid-modal').modal('show');
                }
            },
            onSubmitRemoteBid() {
                this.errorFlag = false;
                this.errorMessage = "";

                let manager = _.head(_.filter(this.$store.getters.teamManagers, [ 'manager_id', parseInt(this.teamDetails.manager_id) ]));
                this.teamSquadSize = parseInt(manager.bids_won) + 1;

                if(this.teamSquadSize > this.squadSize) {
                    this.errorFlag = true;
                    this.errorMessage = "Team is full"
                }

                if(this.currentManager.team_budget < parseFloat(this.form.opening_bid)) {
                    this.errorFlag = true;
                    this.errorMessage = "Budget is lower than bid"
                }

                this.submitted = true;
                this.$validator.validate().then(valid => {
                    

                    if (valid && !this.errorFlag) {
                        
                        axios.get(route('manage.lonauction.team.club.players.count', {division: this.$store.getters.getDivisionId, team: this.currentManager.team_id, club: this.form.club_id}))
                        .then((response) => {
                            let result = response.data;

                            if(result.success) {

                                //check formation
                                if(typeof result.availablePostions != "undefined") {
                                    let chkFormat = _.indexOf(result.availablePostions, this.form.position);

                                    if(chkFormat < 0) {
                                        this.errorFlag = true;
                                        this.errorMessage = "Invalid formation";
                                    }
                                }

                                if(!this.errorFlag && this.secondsForRM > 0) {
                                    this.form.opening_bid = parseFloat(this.form.opening_bid);
                                    this.submitted = false;                                    
                                    this.formSubmitted = true;
                                    this.$store.dispatch('updateplayerAuction', [this.form])
                                    $('#bid-modal').modal('hide');
                                }
                            } else {
                                this.errorFlag = true;
                                this.errorMessage = result.message;
                            }

                        })
                        .catch((error) => {
                            console.log(error)
                        });
                        
                    } else {
                        console.log('ERROR!!')
                    }
                });
            },
            updateSecondsForRM: function(){
                this.secondsForRM--;
                this.timestampForRM++;
                if (this.timestampForRM >= this.$store.getters.nominateRMPlayerTimestamp) {
                    clearInterval(this.interval);
                    this.interval = "";
                    if(this.formSubmitted) {
                        this.$store.dispatch('changeAuctiontioneerScreen', 'highBid')
                    }                    
                }
            },
            updateSecondsForRMNew: function(){
                this.secondsForRM--;
                this.timestampForRM++;
                if (this.timestampForRM >= this.$store.getters.nominateRMPlayerTimestamp) {
                    clearInterval(this.interval1);
                    this.interval1 = "";
                    if(this.formSubmitted) {
                        this.$store.dispatch('changeAuctiontioneerScreen', 'highBid')
                    }                    
                }
            },
            updateNominateRMPlayerTimestamp: function() {
                this.nominateRMPlayerTimestamp--;
            }

		},
	}
</script>