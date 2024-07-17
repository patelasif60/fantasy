<template>
	<div>
		
		<p>
			It is {{ form.opening_bid_manager_name }}’s turn to nominate a player. Please input the player name below along with their opening bid.
		</p>
		<form @submit.prevent="onSubmit" name="stepform1">
			
            <div class="form-group">
                <label for="player-name">Player Name</label>

                <suggestions
                    v-model="form.player"
                    :options="options"
                    :onInputChange="onCountryInputChange"
                    name="player"
                    v-validate="'required'"
                    :class="{ 'is-invalid': submitted && errors.has('opening_bid') }"
                />
                <div v-if="submitted && errors.has('player')" class="invalid-feedback d-block">
                    Please search player and select from list
                </div>
            </div>

            <div class="form-group">
                <label for="player-name">Value (£m)</label>
                <input type="text" 
                	class="form-control" 
                	name="opening_bid" 
                	v-model="form.opening_bid"
                	placeholder="e.g. 0.5" 
                	v-validate="'required|decimal:3'"
                	:class="{ 'is-invalid': submitted && errors.has('opening_bid') }"
                	autocomplete="off">

                <div v-if="submitted && errors.has('opening_bid')" class="invalid-feedback d-block">This field must be numeric and may contain 3 decimal points.</div>
            </div>

            <div class="custom-alert alert-tertiary" v-if="errorFlag">
                <div class="alert-icon">
                    <img src="/assets/frontend/img/cta/icon-whistle.svg" alt="alert-img">
                </div>
                <div class="alert-text text-body">
                    {{ errorMessage }}
                </div>
            </div>

		    <div class="mb-2">
		        <button type="submit" class="btn btn-primary btn-block">
		        	Next
		        </button>
		    </div>
		</form>
	</div>
</template>

<script>
    import VueSimpleSuggest from 'vue-simple-suggest'
    import VeeValidate from "vee-validate";
    Vue.use(VeeValidate);

    import Suggestions from 'v-suggestions'
    Vue.component('suggestions', Suggestions)

    export default {
        props: [ 'maxClubPlayers', 'squadSize' ],
		data() {
			return {
                options: {
                            autocomplete: 'off',
                            inputClass: 'form-control',
                            placeholder: "Start typing player name or shortcode"
                        },
                form: {
                	player_first_name: '',
                    player_last_name: '',
                    player: '',
                    player_id: 0,
                    opening_bid: '',
                    opening_bid_manager_id: '',
                    opening_bid_manager_name: '',
                    round: 1,
                    position: '',
                    club: '',
                    club_short_code: ''
                },
                players: [],
                displayPlayers: [],
                autoCompleteStyle : {
					vueSimpleSuggest: "position-relative",
					inputWrapper: "",
					defaultInput : "form-control",
					suggestions: "",
					suggestItem: "list-group-item"
		        },
		        submitted: false,
                teamSquadSize: '',
                errorFlag: false,
                errorMessage: '',
                currentManager: []
			}
		},
        mounted() {
            var nextManager = _.head(_.filter(this.$store.getters.teamManagers, [ 'order', this.$store.getters.currentBidManagerIndex ]));

            this.currentManager = nextManager;
            this.form.opening_bid_manager_id = nextManager.manager_id;
            this.form.opening_bid_manager_name = nextManager.first_name+" "+nextManager.last_name;
            this.teamSquadSize = parseInt(nextManager.bids_won) + 1;
            if(isNaN(this.teamSquadSize)) {
                this.teamSquadSize = 0
            }
            setInterval(function(){
                $('.v-suggestions input').attr('autocomplete', 'off');
            }, 50)
        },
        methods: {
            onCountryInputChange (query) {
                if (query.trim().length <=2) {
                    return null
                }

                return new Promise(resolve => {
                    axios.get(route('manage.live.online.auction.search.players', {division: this.$store.getters.getDivisionId, player: query.trim()}))
                        .then((response) => {
                            var players = response['data'];
                            var playerData = {};
                            var items = []
                            _.forEach(players, function(player, index) {
                                items.push(player.display_name);
                                playerData[player.id] = player.display_name;
                            })
                            this.players = players;
                            this.displayPlayers = playerData;
                            resolve(items)
                        })
                })
            },

        	getPlayers: function() {
                axios.get(route('manage.live.online.auction.search.players', {division: this.$store.getters.getDivisionId, player: this.form.player}))
                    .then((response) => {
                        var players = response['data'];
                        var playerData = {};

                        _.forEach(players, function(player) {
                        	playerData[player.id] = player.display_name;
                        });

                        this.players = players;
                        this.displayPlayers = playerData;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

                return _.values(this.displayPlayers);
            },
            onSubmit() {
            	var playerId = _.findKey(this.displayPlayers, _.partial(_.isEqual, this.form.player));

                if(typeof playerId == "undefined") {
                    this.form.player = '';
                }

                this.errorFlag = false;
                this.errorMessage = "";

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
                    
                    this.form.player_id = parseInt(playerId)

                    if (valid && typeof this.players[playerId] != "undefined" && !this.errorFlag) {
		            	
                        axios.get(route('manage.lonauction.team.club.players.count', {division: this.$store.getters.getDivisionId, team: this.currentManager.team_id, club: this.players[playerId].club_id}))
                        .then((response) => {
                            let result = response.data;

                            if(result.success) {

                                //check formation
                                if(typeof result.availablePostions != "undefined") {
                                    let chkFormat = _.indexOf(result.availablePostions, this.players[playerId].position);

                                    if(chkFormat < 0) {
                                        this.errorFlag = true;
                                        this.errorMessage = "Invalid formation";
                                    }
                                }

                                if(!this.errorFlag) {
                                    this.form.position = this.players[playerId].position;
                                    this.form.club = this.players[playerId].club_name;
                                    this.form.club_id = this.players[playerId].club_id;
                                    this.form.player_first_name = this.players[playerId].first_name;
                                    this.form.player_last_name = this.players[playerId].last_name;
                                    this.form.club_short_code = this.players[playerId].club_short_code;
                                    this.form.opening_bid = parseFloat(this.form.opening_bid);

                                    this.submitted = false;
                                    this.$store.dispatch('updateplayerAuction', [this.form, 'highBid'])
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
		    }
        }
	};
</script>