<template>
    <div class="text-white" v-if="playerAuctionData">
        
        <ul class="custom-list-group list-group-white mb-4">
            <li>
                <div class="list-element">
                    <span>Nominated player</span>
                    <span>{{ playerAuctionData.player }}</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Nominated by</span>
                    <span>{{ playerAuctionData.opening_bid_manager_name }}</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Highest bid</span>
                    <span>£{{ playerAuctionData.high_bid_value }}m</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Highest bidder</span>
                    <span>{{ playerAuctionData.high_bidder_name }}</span>
                </div>
            </li>
        </ul>

        <div class="custom-alert alert-tertiary" v-if="errorFlag">
            <div class="alert-icon">
                <img src="/assets/frontend/img/cta/icon-whistle.svg" alt="alert-img">
            </div>
            <div class="alert-text text-body">
                You have automatically passed on this player.<br>
                Reason: {{ errorMessage }}
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <p class="font-weight-bold">Remote Bids</p>
            <p class="bg-primary px-2 small">{{ secondsForRM }} seconds</p>
        </div>

        <ul class="custom-list-group list-group-white mb-4">
            <li v-for="manager in this.$store.getters.remoteManagers">
                <div class="list-element">
                    <span>{{ manager.first_name + " " +manager.last_name }}</span>
                    <span v-if="playerAuctionData.remote_manager">
                        <span v-if="playerAuctionData.remote_manager[manager.manager_id] > 0">
                            £{{ playerAuctionData.remote_manager[manager.manager_id] }}m
                        </span>
                        <span v-if="playerAuctionData.remote_manager[manager.manager_id] == 0">
                            Pass
                        </span>
                    </span>
                    <span v-else>-</span>
                </div>
            </li>
        </ul>
        
        <form @submit.prevent="onSubmitRemoteBid" name="stepform2" v-if="allowBid">
            
            <div class="form-group" v-if="!passBidFlag">
                <label for="value">Bid (£m)</label>
                <input type="text" class="form-control" id="remote_bid" name="remote_bid" placeholder="35.5" v-model="form.remote_bid" v-validate="'required|decimal:3|isBigger|teamBudget'"
                    :class="{ 'is-invalid': submitted && errors.has('remote_bid') }"
                    autocomplete="off">

                <div v-if="submitted && errors.has('remote_bid')" class="invalid-feedback d-block">This field must be numeric and may contain 3 decimal points.</div>
            </div>

            <div class="row mb-2 gutters-md" v-if="!passBidFlag">
                <div class="col-sm-6">
                    <button type="button" class="btn btn-outline-white btn-block" @click="passBid" :disabled="submitBidFlag">Pass (no bid)</button>
                </div>
                <div class="col-sm-6 mt-2 mt-sm-0">
                    <button type="submit" class="btn btn-primary btn-block">Submit bid</button>
                </div>
            </div>

        </form>

    </div>
</template>

<script>
    var moment = require('moment');
    export default {
        components: {
            
        },
        props: [ 'teamDetails', 'maxClubPlayers', 'squadSize' ],
        data() {
            return {
                form: {
                    remote_bid: '',
                    manager_id: ''
                },
                submitted: false,
                secondsForRM: '',
                timestampForRM: '',
                playerAuction: [],
                interval: '',
                passBidFlag: false,
                submitBidFlag: false,
                errorFlag: false,
                errorMessage: '',
                allowBid: false
            }
        },
        mounted() {
            this.$validator.extend('isBigger', (value) => {
                return value > this.playerAuctionData.high_bid_value;
            }, {
                hasTarget: true
            });

            this.$validator.extend('teamBudget', (value) => {

                var manager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', this.form.manager_id]));
                    return manager.team_budget > value;
            }, {
                hasTarget: true
            });

            var vm = this;
            vm.$store.dispatch('getCurrentTimestamp')
            
            this.form.manager_id = this.teamDetails.manager_id
            
            setTimeout(function() {
                vm.playerAuction = vm.$store.getters.playerAuction;
                vm.timestampForRM = vm.$store.getters.currentTimestamp;

                var now  = moment.unix(vm.$store.getters.currentTimestamp).format("DD/MM/YYYY HH:mm:ss");
                var then = moment.unix(vm.$store.getters.rmBidTimestamp).format("DD/MM/YYYY HH:mm:ss");

                vm.secondsForRM = moment(then,"DD/MM/YYYY HH:mm:ss").diff(moment(now,"DD/MM/YYYY HH:mm:ss"), 'seconds')

                vm.interval = setInterval(() => {
                  vm.updateSecondsForRM();
                }, 1000);

                vm.checkBidAllowedForManager();

            }, 500);
            
        },
        watch: {
            allowBid() {
                return this.allowBid
            }
        },
        computed: {
            playerAuctionData() {
                return this.$store.getters.playerAuction;
            }
        },
        methods: {
            checkBidAllowedForManager() {
                
                this.errorFlag = false;
                this.errorMessage = "";

                var manager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', this.form.manager_id]));
                this.teamSquadSize = parseInt(manager.bids_won) + 1;

                if(this.teamSquadSize > this.squadSize) {
                    this.errorFlag = true;
                    this.errorMessage = "Your team is full"
                }

                if(manager.team_budget < parseFloat(this.playerAuctionData.opening_bid)) {
                    this.errorFlag = true;
                    this.errorMessage = "Budget is lower than opening bid"
                }

                if(!this.errorFlag) {
                    axios.get(route('manage.lonauction.team.club.players.count', {division: this.$store.getters.getDivisionId, team: manager.team_id, club: this.playerAuctionData.club_id}))
                        .then((response) => {
                            let result = response.data;

                            if(result.success) {

                                //check formation
                                if(typeof result.availablePostions != "undefined") {
                                    let chkFormat = _.indexOf(result.availablePostions, this.playerAuctionData.position);

                                    if(chkFormat < 0) {
                                        this.errorFlag = true;
                                        this.errorMessage = "Invalid formation";
                                    } else {
                                        this.allowBid = true
                                    }
                                }
                            } else {
                                this.errorFlag = true;
                                this.errorMessage = result.message;
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                        });
                }
            },
            onSubmitRemoteBid() {
                this.submitted = true;
                this.$validator.validate().then(valid => {
                    if (valid && !this.errorFlag && this.allowBid) {
                        this.submitBidFlag = true
                        this.submitted = false;
                        this.form.remote_bid = parseFloat(this.form.remote_bid)
                        this.$store.dispatch('submitRemoteManagerBid', this.form)
                        this.form.remote_bid = ""                            
                    } else {
                        console.log('ERROR!!')
                    }
                });
            },
            passBid() {
                this.passBidFlag = true
                this.form.remote_bid = 0
                this.$store.dispatch('submitRemoteManagerBid', this.form)
                this.form.remote_bid = ""
            },
            updateSecondsForRM() {
                this.secondsForRM--;
                this.timestampForRM++;
                if (this.timestampForRM >= this.$store.getters.rmBidTimestamp) {
                    clearInterval(this.interval);
                }
            }
        }
    };
</script>