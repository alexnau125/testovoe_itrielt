@extends('layout.app')

@section('title', 'Авторизация')

@section('content')


    Создать мероприятие:<br>
    <form action="{{ route('event.store') }}" method="POST">
        <label for="name">Название</label>
        <input id="name" name="name" value="">
        <input type="submit" value="Создать">
        @csrf
    </form>
@endsection
