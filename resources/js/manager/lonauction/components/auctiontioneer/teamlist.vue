<template>
    <table class="table custom-table">
        <thead class="thead-dark">
            <tr>
                <th>Team</th>
                <th class="text-center">Bids won</th>
                <th class="text-center">Budget</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="manager in teamManagers">
                <td>
                    <div><a href="javascript:void(0)" @click="$emit('showTeamPlayers', manager.team_id)" class="team-name link-nostyle">{{manager.team_name}}</a></div>
                    <div><a href="javascript:void(0)" @click="$emit('showTeamPlayers', manager.team_id)" class="player-name link-nostyle small">{{manager.first_name + ' ' + manager.last_name}}</a></div>
                </td>
                <td class="text-center">{{manager.bids_won ? manager.bids_won : 0}}</td>
                <td class="text-center">£{{manager.team_budget}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
	export default {
		computed: {
			teamManagers() {
				return this.$store.getters.teamManagers
			}
		},
	}
</script>