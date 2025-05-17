@extends('layouts.base')

@section('name', 'Авторизация')

@section('main')

    <div class="container">
        <div class="row">

            <div class="col-6 offset-3 border text-center p-3">

                <form action="{{ route('login.auth') }}" method="post">
                    @csrf
                    <label for="">Email</label><br>
                    <input class="input-form" type="email" required name="email" placeholder="email"><br>
                    <label for="">Пароль</label><br>
                    <input class="input-form" type="password" required name="password" placeholder="password"><br>
                    <button class="btn btn-primary mt-3">Авторизация</button>
                    <p>Нет аккаунта? - <a href="{{ route('login.register') }}">Регистрация</a></p>
                </form>

            </div>

        </div>
    </div>

@endsection