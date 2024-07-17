
@push('plugin-scripts')
@endpush

<!-- For Javascript variable -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    @if(isset($backUrl) && trim($backUrl) != "")
                        <a href="{{route($backUrl)}}">
                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                        </a>
                    @else
                        <a href="javascript:void(0);" onclick="javascript:history.back();">
                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                        </a>
                    @endif
                   
                </li>
                <li class="text-center has-dropdown has-arrow">
                    {{ isset($title) && $title != "" ? $title : "Page Details"}}
                    {{-- <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span> --}}
                </li>
                <li class="text-right">
                    @if(isset($skipUrl) && trim($skipUrl) != "")
                        <a href="{{ isset($skipUrl) && $skipUrl != "" ? $skipUrl : "#"}}""> Skip &nbsp;&nbsp;<span><i class="fas fa-chevron-right"></i></span></a>
                    @elseif(isset($other) && trim($other) != "")
                        {!! $other !!}
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
