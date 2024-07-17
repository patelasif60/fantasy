<form action="#" class="js-player-filter-form" method="POST">
    <div class="block">
        <div class="block-content block-content-full">
                <div class="form-group row">
                    <div class="col-6">
                        <label for="filter-position">Position:</label>
                        <select name="position" id="filter-position" class="form-control js-player-filter-form js-select2">
                            <option value="">Please select</option>
                            @foreach($positions as $id => $type)
                                 <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="filter-club">Club:</label>
                        <select name="club" id="filter-club" class="form-control js-player-filter-form js-select2">
                            <option value="">Please select</option>
                            @foreach($clubs as $id => $club){
                                 <option value="{{ $club->id }}">{{ $club->name }}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>
               
        </div>
    </div>
</form>

<table class="table table-vcenter table-hover custom-table manager-teams-list-table mt-100" data-url="{{ route('manager.leaguereports.player.data', ['division' => $division]) }}"></table>