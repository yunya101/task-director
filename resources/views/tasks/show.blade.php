@extends('layouts.base')

@section('name', 'Задача')

@section('main')

    <div class="container">
        <div class="row">
            <div class="col-8 offset-2 border p-3">

                <form action="{{ route('tasks.update', ['task' => $task, 'group' => $group]) }}" method="post">
                    @csrf
                    @method('put')
                    <h2>Название задачи:
                        <input type="text" name="title" id="title" value="{{ $task->title }}">
                    </h2>
                    <label for="">Дата выполнения:</label><br>
                    <input type="date" name="deadline" value="{{ $task->deadline }}"><br>
                    <label for="">Описание задачи</label><br>
                    <input type="text" name="description" value="{{ $task->description }}"><br>
                    <label for="">Исполнитель: </label>
                    <select name="executor">
                        <option value="{{ $executor->id }}">{{$executor->name}}</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{$member->name}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Сохранить изменения</button>
                </form>

                <form action="{{ route('tasks.destroy', ['task' => $task, 'group' => $group]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Удалить задачу</button>
                </form>

            </div>
        </div>
    </div>

@endsection