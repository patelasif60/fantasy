require('../../vue-bootstrap');

import axios from 'axios';
import VueAxios from 'vue-axios';
import VueLodash from 'lodash';

Vue.use(VueAxios, axios, VueLodash);

Vue.use(require('vue-moment'));

axios.defaults.headers.common = {
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
};

Vue.mixin({
	methods: {
	    slimScroll() {
	        if ($(window).width() > 991) {
	        	window.scrollTo(0,0);
	        	$('scrollbar').mCustomScrollbar("destroy");
	        	let ContentHeight = $('.js-left-pitch-area').height();
	            $('.scrollbar').mCustomScrollbar({
	                scrollButtons:{enable:true},
	                theme:"light-thick",
	                scrollbarPosition:"outside",
	                mouseWheel:{ enable: true }
	            });
	            
	            $(function(){
	                $('.player-data').height(ContentHeight);
	            });
	        } else {
	            $('scrollbar').mCustomScrollbar("destroy");
	        }
	    },
	    isMobileScreen() {
    	   	if(window.innerWidth <= 800 && window.innerHeight <= 670) {
    	   		return true;
		   	} else {
		   		return false;
		   	}
	    }
	}
})

Vue.component('teamLineup', require('./team_lineup.vue'));

const app = new Vue({
    el: '#team-lineup-page'
});

fitty('.player-wrapper-title', {
    minSize: 7,
    maxSize: 11
});