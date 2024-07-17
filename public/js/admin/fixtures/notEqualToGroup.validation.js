var AdminFixtureLineupsStore = function() {
    
    var initFormValidations = function ( $form ) {
        
        $form = $('#' + $form);
        $form.validate(Global.buildValidateParams({
            //
        }));
    
        $form.find("select[name^='formation[']").each(function() {
            $(this).rules('add', {
                required:   true,
            });
        });
        $form.find("select[name^='player[']").each(function() {
            $(this).rules('add', {
                required:        $(this).hasClass("default"),
                notEqualToGroup: [".players"],
                messages: {
                    notEqualToGroup: 'Player already selected. Please selected a different Player.'
                }
            });
        });
    };
    
    var initSelect2 = function ( $form ) {
        $form = $('#' + $form);
        $form.find("select[name^='formation']").select2({
            allowClear: true,
            placeholder: 'Select a Formation'
        });
        $form.find("select[name^='player']").select2({
            allowClear: true,
            placeholder: 'Select a Player'
        });
       
    };
   
   var initOnTabSwitch = function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            //Get Selected Tab's form
            $form = getActiveTabForm();
            initFormValidations( $form );
            initSelect2( $form );
        });    
   }
   
   var getActiveTabForm = function() {
        var $tab = $('.tab-content'), 
        $active = $tab.find('.active'), 
        $selectedForm = $active.find('form').attr('id');
        
        return $selectedForm;
   }

    return {
        init: function() {
            $form = getActiveTabForm();
            initFormValidations( $form );
            initSelect2( $form );
            initOnTabSwitch();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminFixtureLineupsStore.init();    
});

/**
 * Return true, if value is already present in the selected  group.
 *
 * Works with all kind of text inputs.

 * @desc Declares a required input element whose value must not be equal to a Group value
 *
 * @name $.validator.methods.notEqualToGroup
 * @type Boolean
 * @cat Plugins/Validate/Methods
 */
jQuery.validator.addMethod("notEqualToGroup", function(value, element, options) {
    // get all the elements passed here with the same class
    var elems = $(element).parents('form').find(options[0]);
    // the value of the current element
    var valueToCompare = value;
    // count
    var matchesFound = 0;
    // loop each element and compare its value with the current value
    // and increase the count every time we find one
    jQuery.each(elems, function(){
            thisVal = $(this).val();
            if(thisVal == valueToCompare){
            matchesFound++;
        }
    });
    // count should be either 0 or 1 max
    if(this.optional(element) || matchesFound <= 1) {
        elems.removeClass('error');
        return true;
    } else {
        elems.addClass('error');
    }
    
}, "Please enter a Unique Value.")
