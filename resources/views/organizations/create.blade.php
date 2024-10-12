@extends('layouts.user')

@section('content')



    <form action="{{ route('organization.store')  }}" method="POST">
        @csrf
        <label for="">Наименование</label>
        <input type="text" class="custom_input" name="name">

        <label for="">Краткое наименование</label>
        <input type="text" class="custom_input" name="short_name">

        <label for="">Фамилия</label>
        <input type="text" class="custom_input" name="user_surname">

        <label for="">Имя</label>
        <input type="text" class="custom_input" name="user_name">

        <label for="">Дата основания</label>
        <input type="date" class="custom_input">

        <button type="submit">Добавить</button>
    </form>
@endsection
