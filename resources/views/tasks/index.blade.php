@extends('layouts.base')

@section('name', 'Задачи')

@section('main')

    <div class="container">
        <div class="row">
            @if (!$tasks->isEmpty())
                @foreach ($tasks as $task)

                    <div class="col-3 border m-3">
                        <a href="{{ route('tasks.show', [$group, $task->id]) }}">{{ $task->title }}</a>
                        <p>{{ $task->description }}</p>
                        <data>{{ $task->deadline }}</data>
                        <p>Исполнитель: <a
                                href="{{ route('users.show', [$executors[$task->id]['id']]) }}">{{ $executors[$task->id]['name'] }}</a>
                        </p>
                    </div>

                @endforeach


            @else
                <h2>В этой группе нет задач</h2>
            @endif

        </div>

        <div class="row text-center">
            <div class="col-6 offset-3">
                <form action="{{ route('tasks.store', $group) }}" method="post">
                    @csrf
                    <label for="">Название задачи</label><br>
                    <input type="text" name="title" id="" required><br>
                    <label for="">Описание задачи</label><br>
                    <input type="text" name="description" placeholder="не обязательно"><br>
                    <label for="">Дата выполнения</label><br>
                    <input type="date" name="deadline" id=""><br>
                    <button class="btn btn-primary m-3" type="submit">Создать задачу</button>
                </form>
            </div>
        </div>
    </div>

@endsection