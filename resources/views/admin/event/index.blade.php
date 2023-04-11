@extends('layout.app')

@section('title', 'Авторизация')

@section('content')

    <a href="{{ route('event.create') }}" class="btn">Добавить мероприятие</a>

    <ul>
        @foreach($events as $event)
            <li>{{ $event->name }}</li>
            <a href="{{ route('event.edit', $event->id) }}" class="btn">редактировать</a>
            <form action="{{ route('event.destroy', $event->id) }}" method="POST">@csrf @method('DELETE') <input type="submit" class="btn" value="удалить"></form>

        @endforeach
    </ul>
@endsection
