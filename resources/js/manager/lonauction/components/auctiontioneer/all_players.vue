<template>
	<div>
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

        <el-table :data="allPlyerData.filter(data => !search || data.first_name.toLowerCase().includes(search.toLowerCase()) || data.last_name.toLowerCase().includes(search.toLowerCase()))" name="allPlyer" class="table-responsive">
            <template slot="empty">No Data Available</template>
            <el-table-column fixed label="PLAYER" width="160" class="text-center">
                <template slot-scope="props">
                    <div class="player-wrapper">
                        <span class="custom-badge custom-badge-lg is-square is-gk" :class="'is-' + props.row.position.toLowerCase().trim()">{{ props.row.position}}</span>
                        <div>
                            <a href="javascript:void(0);" class="team-name link-nostyle text-capitalize">
                                {{ props.row.first_name }} {{ props.row.last_name}}
                            </a>
                            <br>
                            <a href="javascript:void(0);" class="player-name link-nostyle small"> {{ props.row.club_name }}
                            </a>
                        </div>
                    </div>
                </template>
            </el-table-column>
            <el-table-column fixed prop="pld" label="PLD" class="text-center" width="55"></el-table-column>
            <el-table-column prop="gls" label="GLS" class="text-center" width="auto"></el-table-column>
            <el-table-column prop="ass" label="ASS" class="text-center" width="auto"></el-table-column>
            <el-table-column prop="cs" label="CS" class="text-center" width="auto"></el-table-column>
            <el-table-column prop="ga" label="GA" class="text-center" width="auto"></el-table-column>
            <el-table-column fixed="right" prop="tot" label="TOT" class="text-center" width="55"></el-table-column>
            <el-table-column fixed="right" class="text-center" width="30">
                <template slot-scope="props">
                    <template v-if='isPlayerSold(props.row.id)'>
                        <span v-html='isPlayerSold(props.row.id)'></span>
                    </template>
                    <template v-else>
                        <div v-if="props.row.available == true">

                        </div>
                        <div v-else>
                            <div v-if="props.row.club_quota == 'exosted'">
                                Quota
                            </div>
                            <div class="quota-player" v-else>
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </template>
                </template>
            </el-table-column>
        </el-table>
	</div>
</template>

<script>
    import VeeValidate from "vee-validate";
    Vue.use(VeeValidate);
    var moment = require('moment');
    import {Element} from 'element-ui';

	export default {
        props: ['clubs', 'positions', 'players', 'division', 'teamDetails'],
        data() {
			return {
                selectedPosition: 'Goalkeeper (GK)',
				selectedClub: '',
				auctionPlayers: {},
                search: '',
			}
		},
        mounted() {
            this.auctionPlayers = _.cloneDeep(this.players);
            setTimeout(function() {
                $(function(){
                    $('.el-table table').addClass('table custom-table mb-0');
                });
            }, 500);

		},
        computed: {
            filteredPlayers:function(event){
                let vm = this;
                return _.filter(this.auctionPlayers, function(player)
                {
                    //player.player_first_name.toLowerCase().match(vm.search.toLowerCase()) ||
                    var name = "";
                    if(player.player_first_name != null) {
                        name = player.player_first_name+" "
                    }
                    name += player.player_last_name;
                    return name.toLowerCase().match(vm.search.toLowerCase());
                });
            },
            allPlyerData:function() {
                let vm =  this;
                let data = [];
                _.forEach(vm.players, function(value) {
                    let playerData = {
                        position: value.position,
                        first_name: value.player_first_name,
                        last_name: value.player_last_name,
                        club_name: value.club_name,
                        pld: value.total_game_played,
                        gls: value.total_goal,
                        ass: value.total_assist,
                        cs: value.total_clean_sheet,
                        ga: value.total_goal_against,
                        tot: value.total,
                        Q: '<i class="el-icon-close"></i>'
                    };
                    data.push(playerData);
                });

                return data;
            }
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
				let vm = this;

                axios.get(route('manage.live.online.auction.players', {'division': this.division, 'position': this.selectedPosition, 'club': this.selectedClub}))
                    .then((response) => {
                        vm.players = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
			},
        },
	}
</script>
