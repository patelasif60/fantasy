var ManagerDivisionCreateTeam = function() {

    var initCreateTeamFormValidations = function () {
        $('.js-create-team-form').validate(Global.buildValidateParams({
            rules: {
                'name': {
                    required: true,
                    remote: {
                        url: route('manager.valid.team.check'),
                        type: "post",
                    }
                },
            },
            messages: {
                name: {
                    remote: "Team name is not invalid.",
                }
            }
        }));
    };

    var initCrestSlider = function () {
        $('.team-carousel .owl-carousel').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            margin: 20,
            stagePadding: 20,
            navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
            dots: true,
            mouseDrag: false,
            autoplay: false,
            responsive: {
                0: {
                    items: 1
                },
                720: {
                    items: 1
                },
                1140: {
                    items: 1
                }
            }
        });
    };

    return {
        init: function() {
            initCreateTeamFormValidations();
            initCrestSlider();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    ManagerDivisionCreateTeam.init();
});

$('input[type=radio][name=crest_id]').change(function() {
    $('.js-create-team').removeClass("btn-gray").addClass("btn-primary");
    $('.js-create-team').prop("disabled", false);
});
