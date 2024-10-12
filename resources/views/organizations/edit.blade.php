@extends('layouts.user')

@section('content')



    <form action="{{ route('organization.update', $organization->id)  }}" method="POST">
        @csrf
        @method('patch')
        <label for="">Наименование</label>
        <input type="text" class="custom_input" name="name" value="{{ $organization->name  }}">

        <label for="">Краткое наименование</label>
        <input type="text" class="custom_input" name="short_name" value="{{ $organization->short_name }}">

        <label for="">Дата основания</label>
        <input type="date" class="custom_input">

        <button type="submit">Обновить</button>
    </form>
@endsection
