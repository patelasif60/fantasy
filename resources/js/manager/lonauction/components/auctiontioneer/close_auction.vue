<template>
    <div>
        <div class="custom-alert alert-tertiary">
            <div class="alert-icon">
                <img src="/assets/frontend/img/cta/icon-whistle.svg" alt="alert-img">
            </div>
            <div class="alert-text text-body">
                <p class="mb-0" v-if="role == 'auctiontioneer'">All teams are now filled. Please review the bids tab and make any necessary ammendments before ending the auction.</p>
                <p class="mb-0" v-else-if="role == 'user'">
                    Your team is filled. You are no longer able to submit bids or nominate players.
                </p>
            </div>
        </div>

        <div class="mt-150" v-if="role == 'auctiontioneer'">
            <button type="submit" class="btn btn-primary btn-block" @click="endLonAuction">
                End auction
            </button>
        </div>
    </div>

</template>

<script>
    
    export default {
        components: {},
        props: [ 'role' ],
		data() {
			return {
                
			}
		},
        mounted() {
        },
        computed: {
        },
        methods: {
            endLonAuction() {
                let divisionId = this.$store.getters.getDivisionId
                axios.post(route('end.lonauction', {division: divisionId}))
                .then((response) => {
                    window.location.href = route('manage.transfer.index', {division: divisionId})
                })
                .catch((error) => {
                    console.log(error)
                });
            }
        }
	};
</script>