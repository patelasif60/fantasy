<template>
    <div class="js-step-four">
        Step Four
        <div class="text-center">
            <button type="button" v-on:click="step('stepThree')" class="btn btn-secondary">Back</button>
            <button type="button" class="btn btn-primary">Save</button>
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
