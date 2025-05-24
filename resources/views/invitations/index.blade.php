@extends('layouts.base')

@section('name', 'Уведомления')

@section('main')

    <div class="container">
        <div class="row">
        @if ($groups->isEmpty())
            <h2>Уведомлений нет</h2>
        @else

            @foreach ($groups as $group)

                <div class="col">
                    <b>{{$group->name}}</b>
                    <p>Кол-во участников: {{$group->count_members}}</p>
                    <form action="{{ route('invitations.accept', ['group_id' => $group->id]) }}" method="post">
                        @csrf
                        <label>Принять приглашение?</label>
                        <input type="checkbox" name="accept" value="0">
                        <button class="btn btn-primary">Отправить</button>
                    </form>
                </div>

            @endforeach

        @endif

        </div>

    </div>

@endsection