<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Line-ups</h3>
        <div class="block-options">
        </div>
    </div>
    <div class="block-content block-content-full">
        <ul class="nav nav-tabs nav-tabs-block js-tabs-enabled" id="lineupTabs" role="tablist">
            @foreach ($lineupTypes as $lineupType)
              <li class="nav-item {{($lineupType == 'Actual') ? 'active' : '' }}">
                <a class="nav-link {{($lineupType == 'Actual') ? 'active show' : '' }}" id="{{strtolower($lineupType)}}-tab" data-toggle="tab" href="#btabs-animated-slideright-{{strtolower($lineupType)}}" aria-selected="true">{{$lineupType}}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="tab-content overflow-hidden">
        @foreach ($lineupTypes as $lineupType)
        <div class="tab-pane  fade fade-right {{($lineupType == 'Actual') ? 'active show' : '' }}" id="btabs-animated-slideright-{{strtolower($lineupType)}}" role="tabpanel">
            @if(isset($lineups[$lineupType]))
                @include('admin.fixtures.lineup.edit')
            @else
                @include('admin.fixtures.lineup.create')
            @endif
            </div>
        @endforeach
    </div>
</div>

