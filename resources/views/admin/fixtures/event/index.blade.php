<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Events</h3>
        <div class="block-options">
            <button type="button" href="{{route('admin.fixture.event.create',['fixture' => $fixture->id])}}" class="btn btn-outline-primary fetch_create_edit_modal"><i class="fa fa-plus mr-5"></i>Add Event</a>
        </div>
    </div>
    <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter table-hover admin-fixture-event-list-table" data-url="{{route('admin.fixture.event.data',['fixture'=>$fixture])}}"></table>
    </div>
</div>