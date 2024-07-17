<template>
	<popper
    trigger="click" :force-show="yourShowState"
    :options="{
      placement: 'top',
      modifiers: { offset: { offset: '0,10px' } }
    }">
        <div class="popper popover bs-popover-top">
            <div class="lineup-modal">
                <div class="lineup-modal-body">
                    <div class="player-wrapper-status" v-if="player.status != null">

                        <span>
                            <img :src="'/assets/frontend/img/status/' + player.status.status.toLowerCase().trim().split(' ').join('') + '.svg'" class="img-status">
                        </span> 
                        {{player.status.description}}
                        <span v-if="player.status.status == 'Suspended' || player.status.status == 'Injured' || player.status.status == 'International'">
                            until {{ player.status.end_date }}
                        </span>

                    </div>

                    <a href="#" class="link-nostyle lineup-modal-stepper">
                        <div class="lineup-modal-content has-icon">
                            <div class="lineup-modal-label">
                                <div class="custom-badge custom-badge-xl is-square is-st">ST</div>
                            </div>
                            <div class="lineup-modal-body">
                                <div class="lineup-modal-title">{{ player.player_first_name }}</div>
                                <div class="lineup-modal-text">{{ player.club_name }}</div>
                            </div>
                        </div>
                    </a>

                    <ul class="list-unstyled">
                        <li>week<span class="points">{{ player.week_total }} pts</span></li>
                        <li>month<span class="points">{{ player.month_total }} pts</span></li>
                        <li>total<span class="points">{{ player.total }} pts</span></li>
                    </ul>

                    <div class="mt-3"></div>

                    <a href="#" class="link-nostyle lineup-modal-stepper">
                        <div class="lineup-modal-content has-icon">
                            <div class="lineup-modal-label">
                                <img src="/assets/frontend/img/status/transfer.svg" class="lbl-img">
                            </div>
                            <div class="lineup-modal-body">
                                <div class="lineup-modal-title">Theo Walcott</div>
                                <div class="lineup-modal-text">Everton</div>
                            </div>
                        </div>
                    </a>

                    <div class="mt-2"></div>

                    <button type="button" class="btn btn-primary btn-block">Confirm</button>

                    <button type="button" class="btn btn-outline-dark btn-block" @click="hidePopper">Cancel</button>
                </div>
            </div>
        </div>

		<a href="www.google.com" class="player-wrapper" data-toggle="modal" data-target="#players-info" slot="reference">
	        <div class="player-wrapper-img">
	            <img class="lazyload tshirt" src="/assets/frontend/img/default/square/default-thumb-50.png" :data-src="player.tshirt" alt="">
	        </div>
	        <div class="player-wrapper-body">
	            <div class="player-wrapper-title">{{ player.player_first_name }}</div>
	            <div class="player-wrapper-description">
	                <div class="custom-badge custom-badge-lg is-square" :class="playerPosition">{{ player.position }}</div>
	                <div class="player-wrapper-text">
	                    <div class="status-indicator"><span></span></div>
	                    <div class="player-points"><span class="points">{{ playerPoints }}</span> pts</div>
	                </div>
	            </div>
	        </div>
	    </a>
        
    </popper>
</template>

<script>
import Popper from 'vue-popperjs';
// import 'vue-popperjs/dist/vue-popper.css';
export default {
    components: {
        'popper': Popper
    },
    props: ['player'],
    data() {
        return {
            yourShowState: false
        };
    },
    computed: {
    	playerPosition() {
    		return "is-"+this.player.position.toLowerCase();
    	},
    	playerPoints() {
    		return this.player.total == null ? 0 : this.player.total;
    	}
    },
    mounted() {
    },
    methods: {    
        hidePopper: function() {
            console.log(this.yourShowState);
            this.yourShowState = !this.yourShowState;
        }
    }
}
</script>