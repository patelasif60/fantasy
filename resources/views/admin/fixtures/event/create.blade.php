
<div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Add Event</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form class="js-fixture-event-create-form" id="js-fixture-event-create-form" action="{{ route('admin.fixture.event.store',['fixture'=>$fixture->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="block">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="event-type" class="required">Event Type:</label>
                                        <select name="event_type" class="form-control" id="event_type">
                                            <option value="">Select a Type</option>
                                            @foreach($event_types as $id => $event_type)
                                            <option value="{{$id}}" 
                                            data-key = "{{$event_keys[$id]['data-key']}}"  
                                            @if(old("event_type") == $id) 
                                            selected = "selected" @endif
                                            >{{$event_type}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label  class="required">Half:</label>
                                        <select name="half" class="form-control" id="half">
                                            <option value="">Select a Type</option>
                                            @foreach($half_types as $id => $type)
                                                <option value="{{$id}}"
                                                @if(old("half") == $id)
                                                selected = "selected" @endif
                                                >{{$type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="minutes" class="required">Minutes:</label>
                                        <input type="text" name="minutes" value="{{old('minutes')}}" class="form-control" id="minutes">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="club" class="required">Club:</label>
                                        <select name="club" class="form-control" id="club">
                                            <option value="">Select Club</option>
                                            @foreach($clubs->pluck('name','id')->all() as $id => $club)
                                            <option value="{{$id}}" >{{$club}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="seconds" class="required">Seconds:</label>
                                        <input type="text" name="seconds" value="{{old('seconds')}}" class="form-control" id="seconds" maxlength="2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="block">
                            <div class="block-content">
                                @foreach($event_type_config as $config)
                                <div id="accordion_{{$config->getKey()}}" class="collapse" role="tabpanel" aria-labelledby="accordion_h{{$config->getKey()}}" data-parent="#accordion">
                                    <div class="row">
                                        @foreach($config->getFieldSettings() as $name => $elem)
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                {!! $config->getHtml($elem,$event_data) !!}    
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
              <button type="submit" id="button-save-fixture-event" class="btn btn-hero btn-noborder btn-default" data-form="#js-fixture-event-create-form">Save</button>
        </div>
    </div>
</div>


