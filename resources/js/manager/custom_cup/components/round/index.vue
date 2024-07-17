<template>
    <div class="js-cup-round">
        <h5>Select the gameweek for Round {{ round }}</h5>
        <div v-for="gameweek in gameWeeks">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" :id="'gameweek-'+ round +'-'+gameweek.id" :v-bind-value="gameweek" @change="gameweekClicked(gameweek)">
                <label class="custom-control-label" :for="'gameweek-'+ round +'-'+gameweek.id"></label>
                Gameweek {{ gameweek.number }}
            </div>
        </div>
        <!-- <div class="p-2 mb-2 bg-light text-dark" v-for="gameweek in gameWeeks">
            Gameweek {{ gameweek.number }}
        </div> -->
    </div>
</template>

<script>
export default {
    components: {
    },
    props: ['form','gameWeeks','round'],
    data() {
        return {
            value: [],
        };
    },
    computed: {
    },
    mounted() {
    },
    methods: {
        step (step) {
          this.$emit('clicked', step);
        },
        gameweekClicked(gameweek) {
            // checkbox is checked
            round.gameweeks.push();

            // checkbox is unchecked
            round.gameweeks.push();

            console.log('gameweekClicked', gameweek);
        }
    }
}
</script>
