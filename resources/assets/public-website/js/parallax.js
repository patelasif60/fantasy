function parallax() {
    if ($(window).width() > 1200) {
        $('.parallax').paroller();
    } else {
        $('.shape-layer').removeClass('parallax');
    }
}
$(window).bind("load", function() {
    parallax();
});
$(window).on("orientationchange, resize", function(event) {
    parallax();
});

// $(".parallax, [data-paroller-factor]").paroller({
//     factor: 0.3,        // +/-, if no other breakpoint factor is set this value is selected
//     factorXs: 0.1,      // factorXs, factorSm, factorMd, factorLg, factorXl
//     factorSm: 0.2,      // factorXs, factorSm, factorMd, factorLg, factorXl
//     factorMd: 0.3,      // factorXs, factorSm, factorMd, factorLg, factorXl
//     factorLg: 0.4,      // factorXs, factorSm, factorMd, factorLg, factorXl
//     factorXl: 0.5       // factorXs, factorSm, factorMd, factorLg, factorXl
//     type: 'foreground',     // background, foreground
//     direction: 'horizontal',// vertical, horizontal
//     transition: 'translate 0.1s ease' // CSS transition, added on elements where type:'foreground'
// });
