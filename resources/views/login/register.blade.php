@extends('layouts.base')

@section('name', 'Регистрация')

@section('main')

    <div class="container">
        <div class="row">

            <div class="col-6 offset-3 border text-center p-3">

                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <label for="email">Введите свой email</label><br>
                    <input class="input-form" type="email" id="email" required name="email" placeholder="email"><br>
                    <label for="name">Придумайте имя пользователя</label><br>
                    <input class="input-form" type="text" id="name" required name="name" placeholder="username"><br>
                    <label for="password">Придумайте пароль</label><br>
                    <input class="input-form" type="password" id="password" required name="password" placeholder="password"><br>
                    <label for="password_confirmation">Повторите пароль</label><br>
                    <input class="input-form" type="password" id="password_confirmation" required name="password_confirmation" placeholder="confirm password"><br>
                    <button class="btn btn-primary mt-3">Регистрация</button>
                    <p>Есть аккаунт? - <a href="{{ route('login.login') }}">Авторизация</a></p>
                </form>

            </div>

        </div>
    </div>

@endsection