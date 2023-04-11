@extends('layout.app')

@section('title', 'Авторизация')

@section('content')

    <h1>Мероприятие: {{ $event->name }}</h1>

    @foreach($eventAgents as $eventAgent)
        <div>
            Пользователь с id: {{ $eventAgent->user_id }}
            @if($eventAgent->status)
                Проверен
            @else
                Не проверен
            @endif
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_{{ $eventAgent->user_id }}">
                Отметить {{ $eventAgent->user_id }}
            </button>
        </div>
        <div class="modal fade" id="exampleModal_{{ $eventAgent->user_id }}" tabindex="-1" aria-labelledby="exampleModalLabel_{{ $eventAgent->user_id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel_{{ $eventAgent->user_id }}">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ $eventAgent->qrcode }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
