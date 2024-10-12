@extends('layouts.user')

@section('content')


    @if (session()->has('login_credentials'))
        <p>Логин: {{ session('login_credentials')['username'] }}</p>
        <p>Пароль: {{ session('login_credentials')['password'] }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <td class="number">№</td>
                <td class="fio">Краткое наименование</td>
                <td class="itog">Действие</td>
            </tr>
        </thead>
        <tbody>
        @foreach($organizations as $organization)
            <tr>
                <td class="num">{{ $loop->iteration  }}</td>
                <td>{{ $organization->short_name  }}</td>

                <td>
                    <a href="{{ route('organization.edit', $organization->id)  }}"><i class="fa-solid fa-pen"></i></a>
                    <a href=""><i class="fa-solid fa-eye"></i></a>
                        
                   
                    

                    
                    <a href="" onclick="event.preventDefault(); document.getElementById('destroy-form').submit();">
                    <i class="fa-solid fa-trash"></i>
                    </a>

                    <form id="destroy-form" action="{{ route('organization.destroy', $organization->id)  }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        @method('DELETE')
                    </form>

                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('organization.create')  }}">Добавить</a>
@endsection
