<template>
    <div class="schedule-supersub">
        <div class="sliding-area">
            <div class="sliding-nav">
                <div class="sliding-items">
                    <div class="owl-carousel js-owl-carousel-date-info js-month-year-filter owl-theme sliding-items-info">
                        <template v-for="(fixture_date, key) in futureFixturesDates">
                            <div class="item info-block js-month">
                                <a href="javascript:void(0)" class="info-block-content  " @click="selectFixture(key)" :class="[key == selectedFixtureDate ? 'is-active' : '']">
                                    <div class="block-section" :class="[checkSavedFixture(key), 'js-' + fixture_date.date_time.replace(/[-:\s]/gi, '')]">
                                    <!-- 'js-' + fixture_date.date_time.replace(/[-:\s]/gi, '') -->
                                        <div class="title">
                                            {{ fixture_date.date }}
                                        </div>
                                        <div class="desc">
                                            {{ fixture_date.time }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { EventBus } from '../../event-bus.js';

export default {
    components: {

    },
    props: ['futureFixturesDates', 'superSubFixtureDates'],
    data() {
        return {
            selectedFixtureDate: '',
        };
    },
    computed: {        
    },
    created() {
        this.selectedFixtureDate = _.keys(this.futureFixturesDates)[0];
    },
    mounted() {
        let vm = this;
        vm.selectedFixtureDate = _.keys(vm.futureFixturesDates)[0]
        EventBus.$on('changeFixture', date => {
            vm.selectFixture(date);
        })
    },
    methods: {
        checkSavedFixture: function(key) {
            // if(key != _.keys(this.futureFixturesDates)[0]) {
                if(! _.includes(this.superSubFixtureDates, key)) {
                    return 'modified-content'
                } else {
                    return '';
                }
            // }
        },
        selectFixture: function(date) {
            $('div.js-owl-carousel-date-info div.js-month').addClass('pointer-events-none');
            this.selectedFixtureDate = date;
            EventBus.$emit('updateSelectedFixture', date);
        }
    }
}
</script>
