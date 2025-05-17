@extends('layouts.base')

@section('name', 'Создать группу')

@section('main')

    <div class="container text-center">
        <div class="row">
            <div class="col-6 offset-3">

                <form action="{{ route('groups.store') }}" method="post">
                    @csrf
                    <label for="">Введите название группы</label><br>
                    <input type="text" name="name" placeholder="name" required><br>
                    <button type="submit" class="btn btn-primary mt-3">Создать</button>
                </form>

            </div>
        </div>
    </div>

@endsection