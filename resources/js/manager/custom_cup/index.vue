<template>
<div>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="top-navigation-bar">
                        <li><a href="#"> <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Cancel </a> </li>
                        <li class="text-center">New cup</li>
                        <li class="text-right"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="body">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-8">
                    <div class="container-wrappper">
                        <div class="container-body">
                            <div class="row mb-100">
                                <div class="col-12 text-white">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="Lineup-tab">
                                            <div class="js-custom-cup-main">
                                                <form class="js-custom-cup-create" method="post">
                                                    <step-one :active-step="activeStep" :active-round="activeRound" @clicked="step" :teams="teams" :default-crest="defaultCrest" :form="form" v-if="activeStep == 'stepOne'"></step-one>
                                                    <step-two :active-step="activeStep" :active-round="activeRound" @clicked="step" :game-weeks="gameWeeks" :form="form" v-if="activeStep == 'stepTwo'"></step-two>
                                                    <step-three :active-step="activeStep" :active-round="activeRound" @clicked="step" :form="form" v-if="activeStep == 'stepThree'"></step-three>
                                                    <step-four :active-step="activeStep" :active-round="activeRound" @clicked="step" :form="form" v-if="activeStep == 'stepFour'"></step-four>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import stepOne from './components/step-one/index.vue';
import stepTwo from './components/step-two/index.vue';
import stepThree from './components/step-three/index.vue';
import stepFour from './components/step-four/index.vue';

export default {
    components: {
        stepOne,stepTwo,stepThree,stepFour
    },
    props: ['teams','defaultCrest','gameWeeks'],
    data() {
        return {
            activeStep:'stepOne',
            activeRound:1,
            form : {
                name: '',
                teams: [],
                rounds: [],
                },
        };
    },
    watch: {
    },
    computed: {
    },
    created() {
    },
    mounted() {
    },
    methods: {
        step (step) {
            console.log('Active step : ',step);
            this.activeStep = step;
        }
    }
}
</script>
