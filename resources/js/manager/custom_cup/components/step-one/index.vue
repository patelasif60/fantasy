<template>
    <div class="js-step-one">
        <div class="form-group">
            <label for="pre_season_auction_budget">Cup name</label>
            <div class="row gutters-sm">
                <input type="text" class="form-control" id="name" name="name" v-model="form.name" value="" placeholder="e.g. My Custom Cup" />
            </div>
            <span class="invalid-feedback animated fadeInDown" role="alert">
                <strong>Name required</strong>
            </span>
        </div>
        <p>Select teams to participate</p>
        <a href="javascript:void(0)" class="link-nostyle team-management-stepper mt-3 mb-3" v-for="team in getAllTeams">
            <div class="team-management-block">
                <div class="team-crest-wrapper">
                    <img class="lazyload league-crest" :src="getdefaultCrest" :data-src="team.crest"  alt="Team Badge">
                </div>
                <div class="team-detail-wrapper">
                    <p class="team-title">{{ team.name }}</p>
                    <p class="team-owner text-dark">{{ team.first_name }} {{ team.first_name }}</p>
                    <p>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" :id="'team-'+team.id" :value="team" v-model="form.teams">
                            <label class="custom-control-label" :for="'team-'+team.id"></label>
                        </div>
                    </p>
                </div>
            </div>
        </a>
        <div class="text-center">
            <button type="button" v-on:click="step('stepTwo')" class="btn btn-primary btn-block">Next</button>
        </div>
    </div>
</template>

<script>

export default {
    components: {
    },
    props: ['teams','defaultCrest','form','activeStep'],
    data() {
        return {

        };
    },
    computed: {
        getAllTeams() {
            return this.teams;
        },
        getdefaultCrest() {
            return this.defaultCrest;
        }
    },
    mounted() {
    },
    methods: {
        step (step) {
          this.$emit('clicked', step);
        }
    }
}
</script>
