@extends('layouts.manager-league-settings')

@section('page-name')
Custom Cups Settings
@endsection

@section('page-action')
    <a href="{{ route('manage.division.custom.cups.create',['division' => $division ]) }}"><span><i class="fas fa-plus"></i></span></a>
@endsection

@section('right')
    @if($customCups->count())
        <ul class="custom-list-group list-group-white">
            @foreach($customCups as $customCup)
                <li>
                    <div class="list-element">
                        <a href="{{ route('manage.division.custom.cups.details',['division' => $division, 'customCup' => $customCup ]) }}" class="has-stepper"><span class="has-icon">{{ $customCup->name }}</span></a>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center"><a href="{{ route('manage.division.custom.cups.create',['division' => $division ]) }}" class="btn btn-primary">Create cup</a></div>
    @endif
@endsection