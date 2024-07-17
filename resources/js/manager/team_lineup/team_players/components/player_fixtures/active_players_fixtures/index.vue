<template>
    <div>
        <table class="table text-center custom-table mb-0">
            <thead class="thead-dark">
                <tr>
                    <th class="text-left">PLAYER</th>
                    <th>TOT</th>
                    <th colspan="2" class="text-left">NEXT FIXTURE</th>
                </tr>
            </thead>
            <tbody v-for="lineupPlayer in activePlayers">
                    <tr v-for="player in lineupPlayer" v-if="lineupPlayer.length">
                        <td class="text-dark">
                            <div class="player-wrapper">
                                <span class="custom-badge custom-badge-lg is-square" :class="playerPosition(player)">{{player.position}}</span>

                                <div class="text-left">
                                    <a href="javascript:void(0);" class="team-name link-nostyle" @click="displaySquadPlayerDetails (player.player_id)">
                                        {{typeof player.player_first_name != "undefined" && player.player_first_name != '' && player.player_first_name != null ? player.player_first_name[0]+" " : "" }}{{player.player_last_name}}
                                    </a>
                                    <br>
                                    <div class="player-name link-nostyle small">{{ player.club_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ playerPoints(player) }}
                        </td>
                        <td v-if="player.next_fixture.type">
                            {{ player.next_fixture.short_code }}({{ player.next_fixture.type }})
                        </td>
                        <td v-else></td>
                        <td>
                            {{ player.next_fixture.date }}
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default {
    components: {
    },
    props: ['activePlayers', 'playerSeasonStats'],
    data() {
        return {
            
        };
    },
    computed: {
        
    },
    mounted() {
        
    },
    methods: {    
        playerPosition(player) {
            return "is-"+player.position.toLowerCase();
        },
        playerPoints(player) {
            var pid = player.player_id;
            return typeof(this.playerSeasonStats[pid]) == 'undefined' ? 0 : this.playerSeasonStats[pid].total;
            // return player.total == null ? 0 : player.total;
        },
        displaySquadPlayerDetails(player_id) {
            this.$emit('displaySquadPlayerDetails', player_id);
        }
    }
}
</script>