<template>
    <div class="list-group-item team-management-stepper team-payment-block" :class="{'position-relative': sortManager}" :key="manager.id">
        <div class="team-management-block">
            <div class="team-detail-wrapper d-flex align-items-center">
                <div class="team-crest-wrapper">
                    <img class="lazyload league-crest" :src="manager.team_crest" :data-src="manager.team_crest" alt="Team Badge" draggable="false">
                </div>
                <div class="ml-2">
                    <p class="team-title">{{manager.team_name}}</p>
                    <p class="team-amount text-dark mb-0">{{manager.first_name}} {{manager.last_name}}</p>
                </div>
            </div>
            <div v-if="!sortManager" class="team-selection-payment">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" :id="'manager' + manager.id" @change="isRemote" :checked="manager.is_remote == 1">
                    <label class="custom-control-label" :for="'manager' + manager.id"></label>
                </div>
            </div>
            <div v-if="sortManager" class="team-selection-payment text-dark handle">
                <i class="far fa-bars"></i>
            </div>
        </div>

        <template v-if="sortManager">
            <div v-if="manager.is_remote == 1" class="remote-manager position-absolute text-uppercase text-white">
                remote
            </div>
        </template>

    </div>
</template>

<script type="text/javascript">
	export default {
		props: ['manager', 'sortManager', 'index'],
		data() {
			return {

			}
		},
		methods: {
			isRemote(event) {
                let is_remote = 0;
                if(event.target.checked) {
                    is_remote = 1;
                }
                this.manager.is_remote = is_remote;
                this.$emit('updateRemoteStat', [this.index, is_remote]);
			}
		}
	}
</script>