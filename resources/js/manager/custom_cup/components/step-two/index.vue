<template>
    <div class="js-step-two">
        <div v-for="round in totalRounds">
            <round v-if="activeRound == round" :game-weeks="gameWeeks" :round="round" @clicked="step" :form="form"></round>
        </div>
        <div class="text-center">
            <button type="button" v-on:click="forwardActiveRound(activeRound)" class="btn btn-primary btn-block">Next</button>
        </div>
    </div>
</template>

<script>
import round from './../../components/round/index.vue';

export default {
    components: {
        round
    },
    props: ['form','activeStep','gameWeeks'],
    data() {
        return {
            value: [],
            activeRound : 1,
        };
    },
    computed: {
        totalRounds() {
            return this.getRounds();
        },
        getGameWeeks() {

            let gameWeeks = [];
            _.forEach(this.gameWeeks, function(value) {
                gameWeeks.push({ name: 'Gameweek '+value.number, id: value.id, gameweek:value });
            });

            return gameWeeks;
        }
    },
    mounted() {
    },
    methods: {
        getRounds() {
            return this.get_nearest_log_value(this.form.teams.length);
        },
        step (step) {
          this.$emit('clicked', step);
        },
        forwardActiveRound(round) {
            if(round < this.getRounds()) {
                round = round + 1;
                this.activeRound = round;
            } else {
                this.$emit('clicked', 'stepThree');
            }
        },
        get_nearest_log_value(number, base = 2) {
            if(number < 0) {

                return 0;
            }

            return Math.ceil(Math.log(number,base));
        }
    }
}
</script>
