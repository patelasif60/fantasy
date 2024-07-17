<template>
    <div v-if="playerAuctionData" v-cloak>

        <p class="mb-5">It is {{ currentBidManager.first_name+" "+currentBidManager.last_name }}’ turn to nominate a player. If they have not nominated player within 60 seconds you may choose to move to the next nominating manager.</p>

        <div class="d-flex justify-content-between align-items-center">
            <p class="font-weight-bold">Nominated player</p>
            <p class="bg-primary px-2 small">{{ secondsForRM }} seconds</p>
        </div>

        <ul class="custom-list-group list-group-white mb-4" v-if="playerAuctionData">
            <li>
                <div class="list-element">
                    <span>Nominated player</span>
                    <span>{{ playerAuctionData.player }}</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Opening bid</span>
                    <span>£{{ playerAuctionData.opening_bid }}m</span>
                </div>
            </li>
        </ul>

        <div class="row mb-2 gutters-md" v-if="noBid">
            <div class="col-sm-6">
                <button type="button" class="btn btn-outline-white btn-block" @click="tryAgain">Try again</button>
            </div>
            <div class="col-sm-6 mt-2 mt-sm-0">
                <button type="button" class="btn btn-primary btn-block" @click="nextManagerChance">Next manager</button>
            </div>
        </div>

    </div>
</template>

<script>
    var moment = require('moment');
    export default {
        components: {
            
        },
        props: [ "currentBidManager", "squadSize" ],
        data() {
            return {
                secondsForRM: '',
                timestampForRM: '',
                playerAuction: this.$store.getters.playerAuction,
                noBid: false
            }
        },
        mounted() {
            var vm = this;

            vm.timestampForRM = vm.$store.getters.defaultBidTime;
            vm.$store.dispatch('getCurrentTimestamp')

            setTimeout(function() {

                vm.timestampForRM = vm.$store.getters.currentTimestamp;

                var now  = moment.unix(vm.$store.getters.currentTimestamp).format("DD/MM/YYYY HH:mm:ss");
                var then = moment.unix(vm.$store.getters.nominateRMPlayerTimestamp).format("DD/MM/YYYY HH:mm:ss");

                vm.secondsForRM = moment(then,"DD/MM/YYYY HH:mm:ss").diff(moment(now,"DD/MM/YYYY HH:mm:ss"), 'seconds')

                if(vm.secondsForRM > 0) {
                    vm.interval = setInterval(() => {
                      vm.updateSecondsForRM();
                    }, 1000);
                } else {
                    vm.secondsForRM = 0;
                    vm.noBid = true
                    vm.$store.dispatch('removeNominateRMPlayerTimestamp')
                }
            }, 500);
        },
        watch: {
            playerAuction() {
                this.playerAuction = this.$store.getters.playerAuction;
            },
            secondsForRM() {
                if(this.secondsForRM == 0) {
                    this.secondsForRM = 0;
                    this.noBid = true
                    this.$store.dispatch('removeNominateRMPlayerTimestamp')
                }
            }
        },
        computed: {
            playerAuctionData() {
                return this.$store.getters.playerAuction;
            }
        },
        methods: {
            updateSecondsForRM: function(){
                this.secondsForRM--;
                this.timestampForRM++;

                if (this.timestampForRM >= this.$store.getters.nominateRMPlayerTimestamp) {
                    clearInterval(this.interval);
                    this.noBid = true
                }
            },
            tryAgain: function() {
                this.noBid = false;
                this.$store.dispatch('setNominateRMPlayerTimestamp')
                
                var vm = this;
                setTimeout(function() {
                    vm.timestampForRM = vm.$store.getters.currentTimestamp;
                    var now  = moment.unix(vm.$store.getters.currentTimestamp).format("DD/MM/YYYY HH:mm:ss");
                    var then = moment.unix(vm.$store.getters.nominateRMPlayerTimestamp).format("DD/MM/YYYY HH:mm:ss");

                    vm.secondsForRM = moment(then,"DD/MM/YYYY HH:mm:ss").diff(moment(now,"DD/MM/YYYY HH:mm:ss"), 'seconds')
                    
                    vm.interval = setInterval(() => {
                      vm.updateSecondsForRM();
                    }, 1000);
                }, 500)
                
            },
            nextManagerChance: function() {
                var newIndex = parseInt(this.$store.getters.currentBidManagerIndex) + 1;
                this.$store.dispatch('changeAuctiontioneerScreen', 'nominatePlayer')
                var teamId = this.checkNextManager(newIndex);
                this.$store.dispatch('setCurrentBidManagerTeamID', teamId)
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
                        if(nextManager.manager_id == this.playerAuctionData.high_bidder_id) {
                            nextManager.squad_size = 1;
                        } else {
                            nextManager.squad_size = 0;
                        }
                    } else {
                        if(nextManager.manager_id == this.playerAuctionData.high_bidder_id) {
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
        }
    };
</script>