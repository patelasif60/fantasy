@extends('layouts.manager-league-settings')

@section('page-name')
Hall of Fame
@endsection

@section('page-action')
    <a href="{{ route('manage.division.history.create',['division' => $division ]) }}"><span><i class="fas fa-plus"></i></span></a>
@endsection

@section('right')
    Listed below are your previous league winners:
    <ul class="custom-list-group list-group-white">
        @foreach($histories as $history)
            <li>
                <div class="list-element">
                    <a href="{{ route('manage.division.history.edit',['division' => $division, 'history' => $history ]) }}" class="has-stepper has-text">
                        <span>{{ $history->season->name }}</span>
                        <span class="has-icon">{{ $history->name }}</span>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
@endsection