<template>
    <div>
        <div class="player-wrapper-img" :class="tshirtClass">        
        </div>

        <div class="player-wrapper-body">
            <div class="badge-area">
                <div class="custom-badge" :class="playerPosition">{{ player.position }}</div>
            </div>
            <div class="player-wrapper-title">{{ playerName }}</div>
            <div class="player-wrapper-description">
                <div class="player-wrapper-text">
                    <div class="player-fixture-sch">
                        <span class="schedule-day">{{ clubShortCode }}</span>
                    </div>
                    <div class="player-points"><span class="points">£{{ player.high_bid }}m</span></div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    
    export default {
        components: {  },
        props: [ "player", "soldPlayers" ],
		data() {
			return {
                playerData: _.head(_.filter(this.$store.getters.soldPlayers, [ 'player_id', parseInt(this.player.player_id) ]))
			}
		},
        mounted() {
        },
        computed: {
            playerPosition() {
                return "is-"+this.player.position.toLowerCase();
            },
            playerName() {
                return this.playerData.player_last_name;
            },
            clubShortCode() {
                return this.playerData.club_short_code;    
            },
            tshirtClass() {
                return this.player.position.toLowerCase() == "gk" ? this.playerData.club_short_code.toLowerCase()+"_gk" : this.playerData.club_short_code.toLowerCase()+"_player";
                
            },
        },
        methods: {

        }
	};
</script>