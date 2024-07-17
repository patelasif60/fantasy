<template>
	<div>
        <div class="form-group">
            <label for="team">Team</label>
            <select class="js-team-select2 custom-select" id="team" v-model="managerData">
                <option value="all">All</option>
                <option v-for="teamManager in teamManagers" :value="teamManager">
                    {{ typeof teamManager != 'undefined' ? teamManager.team_name : '' }}
                </option>
            </select>
        </div>
        <div class="form-group" v-if="managerData != 'all'">
            <table class="table custom-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Remaining budget</th>
                        <th class="text-right">£{{managerData.team_budget}}m</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table custom-table" v-if="soldPlayers.length > 0">
                <thead class="thead-dark">
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th class="text-center">£M</th>
                        <th class="text-center">Round</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="player in soldPlayers">
                        <td>
                            <div class="player-wrapper">
                                <span class="custom-badge custom-badge-lg is-square" :class="'is-' + player.position.toLowerCase().trim()">{{player.position}}</span>

                                <div>
                                    <a href="#" class="team-name link-nostyle">{{player.player}}</a>
                                    <br>
                                    <a href="#" class="player-name link-nostyle small">{{player.club}}</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div><a href="#" class="team-name link-nostyle">{{teamName(player.team_id)}}</a></div>
                            <div><a href="#" class="player-name link-nostyle small">{{ player.high_bidder_name }}</a></div>
                        </td>
                        <td class="text-center">{{player.high_bid_value}}</td>
                        <td class="text-center">{{player.round}}</td>
                        <td class="text-center">
                            <i class="fas fa-chevron-right cursor-pointer text-dark" @click="$emit('showBidEditForm', [true, player.player_id]);"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
	</div>
</template>

<script>
    export default {
        components: {
        },
        props: [],
		data() {
			return {
                managerData: 'all',
				teamManagers: [],
			}
		},
        mounted() {
        	this.teamManagers = this.$store.getters.teamManagers;
        },
        computed: {
            soldPlayers() {
                let soldPlayers = this.$store.getters.soldPlayers
                if(this.managerData != 'all') {
                    soldPlayers = _.filter(soldPlayers, [ 'team_id', parseInt(this.managerData.team_id) ])
                }
                return soldPlayers;
            }
        },
        methods: {
            back() {
            },
            teamName(team_id) {
            	let manager = _.head(_.filter(this.teamManagers, [ 'team_id', parseInt(team_id) ]));
            	return typeof manager != 'undefined' ? manager.team_name : '';
            },
        }
	};
</script>