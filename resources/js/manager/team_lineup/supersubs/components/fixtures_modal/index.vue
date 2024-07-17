<template>
    <div class="modal fade fixtureModal" id="fixtureModal" tabindex="-1" role="dialog" aria-labelledby="fixtureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered lineup-modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="text-dark font-weight-bold text-center mb-4">{{ selectedFixtureDate | moment("dddd Do MMMM YYYY - HH:mm") }}</h6>
                    
                    <div class="fixture-schedule" v-for="fixture in fixturesForModal">
                        <div class="team-name text-right">{{ fixture.home_club_name }}</div>
                        <div class="opposite-team text-center">v</div>
                        <div class="team-name">{{ fixture.away_club_name }}</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {
    },
    props: ['fixturesForModal', 'selectedFixtureDate'],
    data() {
        return {

        };
    },
    computed: {
        
    },
    mounted() {
        
    },
    methods: {

    }
}
</script>
