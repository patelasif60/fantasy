<template>
    <div class="js-step-three">
        Step Three
        <div class="text-center">
            <button type="button" v-on:click="step(2)" class="btn btn-secondary">Back</button>
            <button type="button" v-on:click="step(4)" class="btn btn-primary">Next</button>
        </div>
    </div>
</template>

<script>

export default {
    components: {
    },
    props: ['form','activeStep'],
    data() {
        return {

        };
    },
    computed: {
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
