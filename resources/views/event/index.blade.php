@extends('layout.app')

@section('title', 'Авторизация')

@section('content')

    <ul>
        @foreach($events as $event)
            <li>{{ $event->name }}</li>
            @if(isset($eventAgents[$event->id]) or $user->isAdmin())
                <a href="{{ route('event_show', $event->id) }}" class="btn btn-success">Войти</a>
            @else
                <form method="POST" action="{{ route('event_join') }}">
                    @csrf
                    <input class="btn btn-primary" value="Присоединиться" type="submit">
                    <input type="text" hidden name="event_id" value="{{ $event->id }}">
                </form>
            @endif

        @endforeach
    </ul>
@endsection
