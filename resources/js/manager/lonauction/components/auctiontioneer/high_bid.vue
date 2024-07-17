<template>
	<div v-if="playerAuctionData">
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
            <li v-if="playerAuctionData.round == 1">
                <div class="list-element">
                    <span>Opening bid</span>
                    <span>£{{ playerAuctionData.opening_bid }}m</span>
                </div>
            </li>
            <li v-if="playerAuctionData.round > 1">
                <div class="list-element">
                    <span>Highest bid</span>
                    <span>£{{ playerAuctionData.high_bid_value }}m</span>
                </div>
            </li>
            <li v-if="playerAuctionData.round > 1">
                <div class="list-element">
                    <span>Highest bidder</span>
                    <span>{{ playerAuctionData.high_bidder_name }}</span>
                </div>
            </li>
        </ul>

		<p v-if="playerAuctionData.round == 1">Once all managers in the room have had a chance to bid on the player, please enter the current high bid.</p>

		<p v-if="playerAuctionData.round > 1">Please input the new high bid from the floor</p>

		<form @submit.prevent="onSubmitHighBid" name="stepform2">

            <div class="form-group">
                <label for="player-name">High bidder</label>                
                <select name="high_bidder_id" class="custom-select p-2 w-100" v-validate="'required'"
				    :class="{ 'is-invalid': submitted && errors.has('high_bidder_id') }" v-model="form.high_bidder_id">

					<option value="">Select</option>
					<option v-for="manager in this.$store.getters.teamManagers" :value="manager.manager_id" v-if="manager.is_remote == 0">{{ manager.first_name }} {{ manager.last_name }} ({{ manager.team_name }})</option>

				</select>

				<div v-if="submitted && errors.has('high_bidder_id')" class="invalid-feedback d-block">This field is required</div>

            </div>
	        
            <div class="form-group">
                <label for="player-name">Value (£m)</label>
                <input type="text" 
                	class="form-control" 
                	name="high_bid_value" 
                	v-model="form.high_bid_value"
                	placeholder="e.g. 0.5" 
                	v-validate="'required|decimal:3|isBigger|teamBudget'"
                	:class="{ 'is-invalid': submitted && errors.has('high_bid_value') }"
                	autocomplete="off">

                <div v-if="submitted && errors.has('high_bid_value')" class="invalid-feedback d-block">{{errors.first('high_bid_value')}}</div>
            </div>

            <div class="custom-alert alert-tertiary" v-if="errorFlag">
                <div class="alert-icon">
                    <img src="/assets/frontend/img/cta/icon-whistle.svg" alt="alert-img">
                </div>
                <div class="alert-text text-body">
                    {{ errorMessage }}
                </div>
            </div>

            <div class="row mb-2 gutters-md">
                <div class="col-sm-6" v-if="(hasRemoteManagers == 1 && isRemoteManager) || hasRemoteManagers <= 0">
                <!-- <div class="col-sm-6" v-if="!hasRemoteManagers"> -->
                    <button type="button" @click="noNewBids" class="btn btn-outline-white btn-block">
                        No new bids
                    </button>
                </div>
                <template v-else>
                    <div class="col-sm-6" v-if="hasRemoteManagers">
                        <button type="button" @click="passToRemote" class="btn btn-outline-white btn-block">
                            Pass (no bids)
                        </button>
                    </div>    
                </template>

                <div class="col-sm-6 mt-2 mt-sm-0" v-if="hasRemoteManagers">
                    <button type="submit" class="btn btn-primary btn-block">
                        Open remote bids
                    </button>
                </div>
                <div class="col-sm-6 mt-2 mt-sm-0" v-else>
                    <button type="button" @click="submitPlayerBid" class="btn btn-primary btn-block">
                        Submit high bid
                    </button>
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
        props: [ 'squadSize' ],
		data() {
			return {
                form: {
                	high_bidder_id: '',
                	high_bidder_name: '',
		        	high_bid_value: '',
		        	team_id: '',
		        },
                submitted: false,
                playerAuction: this.$store.getters.playerAuction,
                errorMessages: {
                    en: {
                        custom: {
                            high_bid_value: {
                                required: 'This field must be numeric and may contain 3 decimal points.',
                                isBigger: 'High bid should be greater than opening bid',
                                teamBudget: 'Team budget is lower than bid amount'
                            }                        
                        }
                    }
                },
                errorFlag: false,
                errorMessage: ""

			}
		},
        mounted() {
            
            this.$validator.localize(this.errorMessages);


            this.$validator.extend('isBigger', (value) => {
                if(this.playerAuctionData.round == 1) {
                    return parseFloat(value) > parseFloat(this.playerAuctionData.opening_bid);
                } else {
                    return parseFloat(value) > parseFloat(this.playerAuctionData.high_bid_value);
                }
            }, {
                hasTarget: true
            });

            this.$validator.extend('teamBudget', (value) => {

                var manager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', this.form.high_bidder_id]));
                if(typeof manager.team_budget == "undefined") {
                    return false
                }
                return manager.team_budget > value;
            }, {
                hasTarget: true
            });

        	var vm = this;
        	setTimeout(function() {
        		vm.playerAuction = vm.$store.getters.playerAuction;
                var manager = _.head(_.filter(vm.$store.getters.teamManagers, ['manager_id', vm.playerAuction.opening_bid_manager_id]));
                if(typeof(manager) != "undefined" && manager.is_remote == 0) {
                    vm.form.high_bidder_id = vm.playerAuction.opening_bid_manager_id
                    vm.form.high_bid_value = vm.playerAuction.opening_bid
                }
        	}, 600)
        },
        computed: {
        	playerAuctionData() {
        		return this.$store.getters.playerAuction;
        	},
            hasRemoteManagers() {
                return this.$store.getters.remoteManagers.length
            },
            isRemoteManager() {
                let manager = _.head(_.filter(this.$store.getters.teamManagers, [ 'manager_id', this.playerAuctionData.opening_bid_manager_id ]))
                return manager.is_remote == 1 ? true : false
            }
        },
        methods: {
            validationErrors() {
                this.errorFlag = false;
                this.errorMessage = "";

                var manager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', this.form.high_bidder_id]));
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
                    var vm = this;
                    axios.get(route('manage.lonauction.team.club.players.count', {division: vm.$store.getters.getDivisionId, team: manager.team_id, club: vm.playerAuctionData.club_id}))
                        .then((response) => {
                            let result = response.data;

                            if(result.success) {

                                //check formation
                                if(typeof result.availablePostions != "undefined") {
                                    let chkFormat = _.indexOf(result.availablePostions, vm.playerAuctionData.position);

                                    if(chkFormat < 0) {
                                        vm.errorFlag = true;
                                        vm.errorMessage = "Invalid formation";
                                    }
                                }
                            } else {
                                vm.errorFlag = true;
                                vm.errorMessage = result.message;
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                        });
                }
                return this.errorFlag;
            },
            onSubmitHighBid() {
            	this.submitted = true;
	            this.$validator.validate().then(valid => {
	                if (valid && !this.validationErrors()) {
	                	var manager = _.filter(this.$store.getters.teamManagers, ['manager_id', this.form.high_bidder_id]);
            			this.form.high_bidder_name = manager[0].first_name+" "+manager[0].last_name;
            			this.form.team_id = manager[0].team_id;
	                	this.submitted = false;
	                	this.form.high_bid_value = parseFloat(this.form.high_bid_value)
                        this.$store.dispatch('setRMBidTimestamp')
	                    this.$store.dispatch('updateplayerAuction', [this.form, 'remoteBids'])
	                } else {
	                	console.log('ERROR!!')
	                }
	            });
		    },
            submitPlayerBid: function() {
                this.submitted = true;
                this.$validator.validate().then(valid => {
                    if (valid) {

                        var manager = _.filter(this.$store.getters.teamManagers, ['manager_id', this.form.high_bidder_id]);
                        this.form.high_bidder_name = manager[0].first_name+" "+manager[0].last_name;
                        this.form.team_id = manager[0].team_id;
                        this.form.high_bid_value = parseFloat(this.form.high_bid_value)

                        if(!this.validationErrors()) {

                            var currManager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', this.playerAuctionData.opening_bid_manager_id]));
                            var teamId = this.checkNextManager(parseInt(currManager.order)+1);
                            this.$store.dispatch('setCurrentBidManagerTeamID', teamId)
                            this.$store.dispatch('updateplayerAuction', [this.form, 'updateTeamBudget'])
                        }
                        
                    } else {
                        console.log('ERROR!!')
                    }
                });
            },
            checkNextManager: function(order) {
                
                if(this.$store.getters.teamManagers.length == order) {
                    order = 0;
                }
                var nextManager = _.head(_.filter(this.$store.getters.teamManagers, [ 'order', order ]));

                //check all players for all teams are filled or not
                var soldPlayers = this.$store.getters.soldPlayers.length + 1;
                var totalPlayers = this.$store.getters.teamManagers.length * parseInt(this.squadSize);


                if(soldPlayers < totalPlayers) {
                    if(typeof nextManager.squad_size == "undefined") {
                        if(nextManager.manager_id == this.form.high_bidder_id) {
                            nextManager.squad_size = 1;
                        } else {
                            nextManager.squad_size = 0;
                        }
                    } else {
                        if(nextManager.manager_id == this.form.high_bidder_id) {
                            nextManager.squad_size = parseInt(nextManager.squad_size) + 1;
                        }
                    }

                    if(nextManager.squad_size >= this.squadSize) {
                        return this.checkNextManager(order+1);
                    } else {
                        return nextManager.team_id;
                    }
                } else {
                    return nextManager.team_id;
                }
            },
            noNewBids: function() {
                var currentManager = _.head(_.filter(this.$store.getters.teamManagers, [ 'manager_id', this.playerAuctionData.opening_bid_manager_id ]));

                this.form.high_bidder_name = currentManager.first_name+" "+currentManager.last_name;
                this.form.team_id = currentManager.team_id;
                this.form.high_bidder_id = this.playerAuctionData.opening_bid_manager_id;
                this.form.high_bid_value = parseFloat(this.playerAuctionData.opening_bid)

                if(!this.validationErrors()) {
                    
                    var currManager = _.head(_.filter(this.$store.getters.teamManagers, ['manager_id', this.playerAuctionData.opening_bid_manager_id]));
                    
                    var teamId = this.checkNextManager(parseInt(currManager.order)+1);
                    this.$store.dispatch('setCurrentBidManagerTeamID', teamId)

                    this.$store.dispatch('updateplayerAuction', [this.form, 'updateTeamBudget'])
                    
                }
            },

            passToRemote() {
                this.$store.dispatch('setRMBidTimestamp')

                var newIndex = parseInt(this.$store.getters.currentBidManagerIndex) + 1;
                var chkIndex = this.$store.getters.teamManagers.length == newIndex ? 0 : newIndex;

                var nextManager = _.head(_.filter(this.$store.getters.teamManagers, [ 'order', chkIndex ]));

                var currentManager = _.head(_.filter(this.$store.getters.teamManagers, [ 'manager_id', this.playerAuctionData.opening_bid_manager_id ]));

                let formData = {
                    high_bidder_name: '',
                    team_id: 0,
                    high_bidder_id: 0,
                    high_bid_value: 0,
                }
                formData.high_bidder_name = currentManager.first_name+" "+currentManager.last_name;
                formData.team_id = currentManager.team_id;
                formData.high_bidder_id = this.playerAuctionData.opening_bid_manager_id;
                formData.high_bid_value = parseFloat(this.playerAuctionData.opening_bid)
                this.$store.dispatch('updateplayerAuction', [formData, 'remoteBids'])
            },
        }
	};
</script>