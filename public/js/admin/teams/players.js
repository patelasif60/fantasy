var AdminTeamPlayersIndex = function() {
    var initDataTable = function () {
        Global.configureDataTables();
          TeamPlayersDatatable = $('table.admin-team-players-list-table').DataTable({
            ajax: {
                url: $('table.admin-team-players-list-table').data('url'),
                method: 'post',
                data: function (d) {
                    $.each(readFilters(), function (key, value) {
                        if (value !== null) {
                            d[key] = value;
                        }
                    });
                }
            },
            columns: [
                {
                    data: 'name',
                    title: "Name",
                    name: 'name'
                },
                {
                    data: 'club',
                    title: "Club",
                    name: 'club'
                },
                {
                    data: 'position',
                    title: "Position",
                    name: 'position'
                },
                {
                    data: 'points',
                    title: "Points",
                    name: 'points',
                    defaultContent: '-'
                },
                {
                    data: 'bid',
                    title: "£M",
                    name: 'bid',
                    defaultContent: '-'
                },

                {
                    data: 'player_id',
                    title: 'Actions',
                    searchable: false,
                    sortable: false,
                    className: 'text-center text-nowrap',
                    render: function(data,type, row, meta ) {
                        return Global.buildModalEditAction(route('admin.team.player.contract.data', { team:row['team_id'],player: data }));
                    }
                }
            ],
            dom: 'Bfrtip',
            buttons: []
        });
    };

    var initDTpicker = function(){
        $form = $('.js-team-player-contract-form');
        $form.find(".datetimepicker").each(function(){
          $(this).datetimepicker();  
        });
    }

    var initAddNewContract = function(){
        $('#add-contract').on('click',function(){
            var $new_html = $('#repeat tbody').html();
            $('#contracts-head').append($new_html);
            initDTpicker();
        })
    }
    
     var initFormValidations = function () {
        $('.js-team-player-contract-form').validate(Global.buildValidateParams({
            rules:{
             //
            }
            ,submitHandler: function(form) {
                
                $.post({
                    url:$(form).attr('action'),
                    type:$(form).attr('method'),
                    data:$(form).serialize(),
                    success:function(response){
                        sweet.success('Congrats !',response.message).then((value)=>{
                            $('#modal-create-edit-box').modal('hide');
                        });                       
                    }
                }).fail(function(response) {
                    if(typeof response.responseJSON.errors != 'undefined' ){
                        sweet.error('Error !',Global.prepareAjaxFormValidationMessage(response.responseJSON.errors));
					}  
                });
            }
        }));
    };
    
   var initRecalculatePoints = function() {
        $('#recalculate-points').on('click',function() {
            var athis =  $(this);
            var url = athis.attr("data-url");
            $('.js-loading-message').removeClass('d-none');
            athis.prop('disabled', true);
            $('#js-team-player-contract-form-save').prop('disabled', true);
            $.post({
              url:url,
              type:$('.js-team-player-contract-form').attr('method'),
              data: $('.js-team-player-contract-form').serialize(),
              success: function(response) {
                    sweet.success('Congrats !',response.message); 
                    $('#modal-create-edit-box').modal('hide');
                    AdminTeamPointsIndex.resetDatatable();
                    AdminTeamPlayersIndex.resetDatatable();
                    $('.js-loading-message').addClass('d-none');
                    athis.prop('disabled', false);
                    $('#js-team-player-contract-form-save').prop('disabled', false);
               }
            }).fail(function(response) {
                    $('.js-loading-message').addClass('d-none');
                    if(typeof response.responseJSON.errors != 'undefined' ) {
                        sweet.error('Error !',Global.prepareAjaxFormValidationMessage(response.responseJSON.errors));
                }
                athis.prop('disabled', false);
                $('#js-team-player-contract-form-save').prop('disabled', false);
            });     
        });
    }

    var initFilters = function () {
        $form = $('.js-player-filter-form');
        $form.on('submit', function(e) {
            e.preventDefault();
            TeamPlayersDatatable.draw();
        });
        $form.find('.players').on('change',function(){
            $form.submit();
        });
        $('#filter-season').on('change', function(e) {
            TeamPlayersDatatable.draw();
        });
    };

    var readFilters = function() {
        var $form = $('.js-player-filter-form');
        return {
            player: $form.find("input[name='player']:checked").val() || null,
            season:  $("#filter-season").val() || null,
            uuid:  $("#filter-uuid").val() || null,
            team:  $("#filter-team_id").val() || null,
        };
    };
    return {
        init: function () {
            initDataTable();
            initFilters();
        },
        resetDatatable: function(){
            TeamPlayersDatatable.draw();
        },
        datepicker:initDTpicker,
        addContract:initAddNewContract,
        recalculatePoints:initRecalculatePoints,
        initFormValidations:initFormValidations
    };
}();

// Initialize when page loads
jQuery(function() {
    AdminTeamPlayersIndex.init();
});


// Initialize when modal loads
$(document).on('show.bs.modal','#modal-create-edit-box',function(){
    AdminTeamPlayersIndex.datepicker();
    AdminTeamPlayersIndex.addContract();
    AdminTeamPlayersIndex.recalculatePoints();
    AdminTeamPlayersIndex.initFormValidations();
});