<template>

    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">

                            <p class="text-white" v-if="!sortManagers">Select all managers that will be participating
                            in the auction remotely. Remote participants
                            must be online for the duration of the
                            auction.</p>

                            <p class="text-white" v-if="sortManagers">Managers will take turns nominating a player to bid on. You can choose the order in which managers take their turn.</p>


                            <draggable
                                :list="managers"
                                class="list-group"
                                ghost-class="ghost"
                                @start=""
                                @end="sortTeamManagers"
                                handle=".handle"
                            >   
                                <template v-for="(manager, index) in managers">    
                                    <ManagerRow :manager="manager" :key='index' :index="index" :sort-manager="sortManagers" @updateRemoteStat="updateRemoteStat"></ManagerRow>
                                </template>
                            </draggable>

                            <div class="mb-2">
                                <button type="button" class="btn btn-primary btn-block" @click="sortManagers = !sortManagers" v-if="!sortManagers">Next
                                </button>
                                <button type="button" class="btn btn-primary btn-block" @click="next" v-if="sortManagers">
                                    <span v-if="this.$store.getters.tempAuctiontioneerScreen != 'start'">Start auction</span>
                                    <span v-else>Resume auction</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    
    import draggable from "vuedraggable";
    import ManagerRow from "./row.vue";
	export default {
        components: {draggable, ManagerRow},
        props: [],
		data() {
			return {
                managers: [],
                sortManagers: false
			}
		},
        mounted() {
            this.managers = this.$store.getters.teamManagers;
        },
        methods: {
            sortTeamManagers() {
                this.$store.dispatch('setSortTeamManagers', this.managers)
            },
            updateRemoteStat(data) {
                let index = data[0];
                let is_remote = data[1];
                this.$store.dispatch('updateRemoteTeamManagers', [this.managers[index].team_id.toString(), is_remote])
                this.managers = this.$store.getters.teamManagers;
            },
            next() {
                this.$store.dispatch('setCurrentBidManagerTeamID', this.managers[0].team_id)
                if(this.$store.getters.tempAuctiontioneerScreen != 'start') {
                    this.$store.dispatch('changeAuctiontioneerScreen', 'nominatePlayer')
                    this.$store.dispatch('updatePlayerAuctionRound', '')
                } else {
                    this.$store.dispatch('removetempAuctiontioneerScreenFlag')
                }                
            }
        }
	};
</script>