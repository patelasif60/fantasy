<template>
    <div>

        <ul class="custom-list-group list-group-white mb-4">
            <li>
                <div class="list-element">
                    <span>Nominated player</span>
                    <span>-</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Nominated by</span>
                    <span>-</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Opening bid</span>
                    <span>-</span>
                </div>
            </li>
        </ul>

        <p class="mt-5">
            It is {{ opening_bid_manager_name }}’s turn to nominate a player. Once they have made their nomination, the player details will appear above.
        </p>
        
    </div>
</template>

<script>
    export default {
        components: {
            
        },
        props: [],
        data() {
            return {
                opening_bid_manager_name: ''
            }
        },
        mounted() {
            var teamManagers = this.$store.getters.teamManagers;

            var currentBidManager = _.head(_.filter(this.$store.getters.teamManagers, [ 'order', parseInt(this.$store.getters.currentBidManagerIndex) ]));
            this.opening_bid_manager_name = currentBidManager.first_name+" "+currentBidManager.last_name
        },
        methods: {
        }
    };
</script>