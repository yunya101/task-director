@extends('layouts.base')

@section('name', 'Задача')

@section('main')

    <div class="container">
        <div class="row">
            <div class="col-6 border p-3">

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
                            @if ($member->id !== $executor->id)
                                <option value="{{ $member->id }}">{{$member->name}}</option>
                            @endif
                        @endforeach
                    </select><br>
                    <button type="submit" class="btn btn-primary mt-3">Сохранить изменения</button><br>
                </form>

                <form class="mt-5" action="{{ route('tasks.destroy', ['task' => $task, 'group' => $group]) }}"
                    method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Удалить задачу</button>
                </form>

            </div>
            <div class="col-3 border ps-3 d-flex flex-column justify-content-between">

                @foreach ($comments as $comment)
                    <div class="m-1 border">
                        <b>{{$members[$comment->user_id]->name ?? 'not data'}}</b>
                        <p>{{$comment->text}}</p>
                    </div>
                @endforeach

                <div class="mt-auto">
                    <form action="{{ route('comments.store', ['group' => $group, 'task' => $task]) }}" method="post">
                        @csrf
                        <textarea name="text" placeholder="оставить комментарий"></textarea>
                        <button class="btn btn-primary">Отправить</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection