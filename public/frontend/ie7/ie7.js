/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'fl-icons\'">' + entity + '</span>' + html;
	}
	var icons = {
		'fl-angle-up': '&#xe905;',
		'fl-badge': '&#xe90a;',
		'fl-bar': '&#xe901;',
		'fl-bar-close': '&#xe902;',
		'fl-chevron-circle-right': '&#xe90b;',
		'fl-facebook': '&#xe907;',
		'fl-info': '&#xe90c;',
		'fl-instagram': '&#xe908;',
		'fl-logo': '&#xe900;',
		'fl-shape-shear': '&#xe906;',
		'fl-star': '&#xe903;',
		'fl-stars': '&#xe904;',
		'fl-trophy': '&#xe90d;',
		'fl-twitter': '&#xe909;',
		'fl-whistle': '&#xe90e;',
		'fl-whistle-cirlcle': '&#xe90f;',
		'fl-winners': '&#xe910;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/fl-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
