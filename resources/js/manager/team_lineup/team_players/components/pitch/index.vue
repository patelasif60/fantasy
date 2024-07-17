<template>
	<div class="pitch-image">
        <img class="lazyload" src="/assets/frontend/img/pitch/pitch-1.jpg" :data-src="getPitchUrl" alt="">
    </div>
</template>

<script>

export default {
    components: {
    },
    props: ['pitchUrl'],
    data() {
        return {

        };
    },
    computed: {
        getPitchUrl() {
            return this.pitchUrl;
        }
    },
    mounted() {

    },
    methods: {

    }
}
</script>
