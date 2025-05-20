@extends('layouts.base')

@section('name', 'Группы')

@section('main')

    <div class="container">
        <div class="row">

            @if (!$groups->isEmpty())

            <h1>Мои группы</h1>
                
                @foreach ($groups as $group)
                    
                    <div class="col-3 border">
                        <a href="{{ route('tasks.index', [$group->id]) }}">{{ $group->name }}</a>
                        <p>Кол-во участников: {{$group->count_members}}</p>
                    </div>

                @endforeach

            @else

            <h2>У вас нет ни одной группы! - <a href="{{ route('groups.create') }}">Создать группу</a></h2>
                
            @endif

        </div>
    </div>

@endsection