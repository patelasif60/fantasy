var AdminFixtureLineupsStore = function() {
    
    var initFormValidations = function ( $form ) {
                
        $form = $('#' + $form);
        $form.validate(Global.buildValidateParams({
            submitHandler: function(form) { 
                var playerValidate = false;

                $form.find('.lineup-container').each(function(){
                    if ($(this).val())
                    {
                        playerValidate = true;
                        //return;
                    }
                });

                if (!playerValidate)
                {
                    sweet.error('Error', 'Please select valid line-ups');
                }else
                {
                    form.submit();   
                }
           }
        }));
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
            setDisabledProperties();
        });    
   }
   
   var getActiveTabForm = function() {
        var $tab = $('.tab-content'), 
        $active = $tab.find('.active'), 
        $selectedForm = $active.find('form').attr('id');
        return $selectedForm;
   }
   
   var selectPlayerOnChange = function(){
        $form = getActiveTabForm();
        $('.' + $form + ' .players').on('change',function(){
            if(typeof $(this).val() != 'undefined'){
                setDisabledProperties();
                $(this).select2({
                    allowClear: true,
                    placeholder: 'Select a Player'
                });
            } else {
                $(this).unshift({text:'Select a player'})
            }
        });
    }

    var manageRule = function(ele,required)
    {   
        if (required){
            $('#' + $form).find(ele).each(function() {
                $(this).rules('add', {
                    required:   true,
                    notEqualToGroup: [".players"],
                    messages: {
                        notEqualToGroup: 'Player already selected. Please selected a different Player.'
                    }
                });
            });
        }
        else
        {
            $(ele).each(function(){
                $(this).rules('remove');
                $(this).closest('.form-group').removeClass('is-invalid');
            });
        }

        setDisabledProperties();
    }

    var lineupFieldValidation = function()
    {
        $('.lineup-container').change(function(){
            var is_required = false;
            if ($(this).val())
            {
                manageRule('.'+$(this).attr('activeLineup'),true);
            }else
            {
                $('.'+$(this).attr('activeLineup')).each(function(){
                    if ($(this).val())
                    {
                        is_required = true;
                        return;
                    }
                });
                manageRule('.'+$(this).attr('activeLineup'),is_required);
            }
        });
    }
    
    var setDisabledProperties = function(){
        $form = getActiveTabForm();
        $('.' + $form + ' .players').each(function(){
            currID = $(this).attr('id');    
            clubType = currID.substr(0,4);
            values = [];
            $('.' + $form + ' .players').each(function(){
                if(currID != $(this).attr('id')) {
                    if($(this). children("option:selected"). val() != ""){
                        values.push($(this).children("option:selected"). val());
                    }
                }
            })  
            
            $(this).children("option").each(function(){    
                $(this).prop('disabled',($.inArray($(this).val(), values) >= 0)? true: false);
            });
        });
    };

    return {
        init: function() {
            $form = getActiveTabForm();
            initFormValidations( $form );
            initSelect2( $form );
            initOnTabSwitch();
            Global.select2Options();
            manageRule();
            lineupFieldValidation();
            selectPlayerOnChange();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminFixtureLineupsStore.init();    
});
