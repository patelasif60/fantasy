var AdminfixtureEventCreate = function() {

    var initFormValidations = function () {
        $('.js-fixture-event-create-form').validate(Global.buildValidateParams({
            rules: {
                'event_type': {
                    required: true,
                },
                'half': {
                    required: true,
                },
                'minutes': {
                    required: true,
                },
                'club': {
                    required: true,
                },
            },
            submitHandler: function(form) {
                $('#button-save-fixture-event').attr('disabled','disabled');
                $.post({
                    url:$(form).attr('action'),
                    type:$(form).attr('method'),
                    data:$(form).serialize(),
                    success:function(response){
                        sweet.success('Congrats !',response.message).then((value)=>{
                            $('#modal-create-edit-box').modal('hide');
                            FixtureEventsList.resetDatatable();
                        });   
                    }
                }).fail(function(response) {
                    $('#button-save-fixture-event').prop('disabled',false);
					if(typeof response.responseJSON.errors != 'undefined' ){
						sweet.error('Error !',Global.prepareAjaxFormValidationMessage(response.responseJSON.errors));
					}  
                });
            }
        }));
    };
    var initSelect2 = function () {
        $form = $('.js-fixture-event-create-form');
        $formselect = $form.find("select");
        $formselect.css('width', '100%');
        $formselect.select2({
            allowClear:false,
        });
    };
    var selectOnChange = function(){
        $form = $('.js-fixture-event-create-form');
        $formeventtypeselect = $form.find("select[name='event_type']");
        $formeventclubselect = $form.find("select[name='club']");
        $formeventtypeselect.on('change',function(){
            $('#accordion_'+$(this).find(':selected').attr('data-key')).collapse('toggle');
            $('#accordion_'+$(this).find(':selected').attr('data-key')).on('shown.bs.collapse',function(){
                initSelect2();
                eventFormManager.init(1); 
            });
            
        });
        $formeventclubselect.on('change',function(){
            eventFormManager.init(1);
        });

    };

    return {
        init: function() {
            initFormValidations();
            initSelect2();
            selectOnChange();
        }
    };
}();


var AdminfixtureEventEdit = function() {

    var initFormValidations = function () {
        $('.js-fixture-event-edit-form').validate(Global.buildValidateParams({
            rules: {
                'event_type': {
                    required: true,
                },
                'half': {
                    required: true,
                },
                'minutes': {
                    required: true,
                },
                'club': {
                    required: true,
                },
            },
            submitHandler: function(form) {
                $('button[data-form="#js-fixture-event-edit-form"]').attr('disabled','disabled');
                $.post({
                    url:$(form).attr('action'),
                    type:$(form).attr('method'),
                    data:$(form).serialize(),
                    success:function(response) {
                        sweet.success('Congrats !',response.message).then((value)=>{
                            $('#modal-create-edit-box').modal('hide');
                            FixtureEventsList.resetDatatable();
                        });   
                    }
                }).fail(function(response) {
                    $('button[data-form="#js-fixture-event-edit-form"]').prop('disabled', false);
                    if(typeof response.responseJSON.errors != 'undefined' ) {
                        sweet.error('Error !',Global.prepareAjaxFormValidationMessage(response.responseJSON.errors));
                    }  
                });
            }
        }));
    };
    var initSelect2 = function () {
        $form = $('.js-fixture-event-edit-form');
        $formselect = $form.find("select");
        $formselect.css('width', '100%');
    };
    var selectOnChange = function(){
        $form = $('.js-fixture-event-edit-form');
        $formeventtypeselect = $form.find("select[name='event_type']");
        $formeventclubselect = $form.find("select[name='club']");
        $formeventtypeselect.on('change',function(){
            $('#accordion_'+$(this).find(':selected').attr('data-key')).collapse('toggle');
            $('#accordion_'+$(this).find(':selected').attr('data-key')).on('shown.bs.collapse',function(){
                initSelect2();
                eventFormManager.init(); 
            });
            
        });
        $formeventclubselect.on('change',function(){
            initSelect2();
            eventFormManager.init();
        });

    };

    return {
        init: function() {
            initFormValidations();
            initSelect2();
            selectOnChange();
            eventFormManager.init();
            Global.select2Options({
                "options": [
                    {
                      "id": '#event_type',
                      "allowClear": false
                    },
                    {
                      "id": '#club',
                      "allowClear": false
                    },
                    {
                      "id": '#half',
                      "allowClear": false
                    }
                  ],
            }); 
        }
    };
}();


var eventFormManager = function(){

    var formElementBuilder = function($type,$name,$data,$details){
        if($type == 'select'){
            if(typeof $('#'+$name) != 'undefined'){
                if(typeof $data != 'undefined'){
                    $('#'+$name).empty();
                    $('#'+$name).select2({data:$data});           
                }
                else{  
                    $('#'+$name).select2();
                }
            }
        }
        else{
            return $('<'+$type+' >',$details).wrap('div').parent().html();
        }        
    };

    var checkObjectValidity = function($obj){
        if(typeof $obj != 'undefined' && Object.keys($obj).length > 0){
            return true;
        }
        return false
    }

    var manageConditions = function($type,$field,$default){
        type_fields_rules = Site.event_type_rules;
        let players = Site.player_data;
        clubs = Site.clubs;
        $elemRules = type_fields_rules[$type][$field];
        if(typeof $elemRules != 'undefined' && Object.keys($elemRules).length>0){
            if($elemRules['values'] == 'club'){
                if($('#club').val() == ''){
                    return []; 
                } 
            }    
        }
        var $bdata = players[clubs[$('#club').val().toString()].toString()]; 
        if($field=='own_assist'){
            var $bdata = players['home']
            if(clubs[$('#club').val().toString()]=='home'){
                 var $bdata = players['away']
            }
        }
        if(typeof $bdata[0] != 'undefined' && typeof $bdata[0]['id'] != 'undefined'){
            if($bdata[0]['id'] != '')
                $bdata.unshift({id:'',text:'Select a player'});
        }
        else{
            $bdata.unshift({id:'',text:'Select a player'});
        }
        return $bdata;
        
    };
    var setup = function($event,$ekey,$add){
        type_fields = $.parseJSON(Site.event_config)[$event.toString()];
        $.each(type_fields,function(key,obj){
            if(typeof obj.event != 'undefined'){
                var event = obj.event.split('_affect');
                $('#'+obj.name).off(event[0]);
                $('#'+obj.name).on(event[0],function(){
                    setDisabledProperties($(this),1);
                });
               
            }
            if(obj.data != 'player_all'){
                setDisabledProperties($('#'+obj['name']));   
                if($('#'+obj['name']).val() == null || typeof $add != 'undefined'){
                    var data = manageConditions($ekey,key,$('#'+obj['name']).val());
                    formElementBuilder(obj['input'],obj['name'],data);
                }
            }
            else{
                setDisabledProperties($('#'+obj['name']));
                formElementBuilder(obj['input'],obj['name']);
            }
            
        });

    };

    var setDisabledProperties = function(obj,change){
        if(typeof obj.data('rules').validation != 'undefined'){
            var opt = obj.select2().val();
            var other = obj.data('rules')['validation']['not_in'];
            $(other).each(function(elmi,elmobj){
                if(typeof $('#'+elmobj) != 'undefined'){
                    if(typeof change != 'undefined' && change == 1){
                         $('#'+elmobj+">option[disabled]").each(function(k,v){
                           
                            var optval = $(this).attr('value');
                            var dis = true;
                            $(other).each(function(kk,vv){
                                if($('#'+vv).val() != optval){
                                    dis = false;
                                }
                            });
                            $(this).prop('disabled',dis);
                        });
                    } 
                    if(opt != ''){
                        $('#'+elmobj+" > option[value='"+opt+"']").prop('disabled',true);
                    }
                    formElementBuilder($('#'+elmobj).get(0).tagName.toLowerCase(),elmobj);  
                }
            });    
        }
    }

    return {
        init:function($add){
            setup($('#event_type').val(),$('#event_type').find(':selected').data('key'),$add);
        }
    };
}();

// Initialize when modal loads
$(document).on('show.bs.modal','#modal-create-edit-box',function(){
    AdminfixtureEventCreate.init();
    AdminfixtureEventEdit.init();
});
