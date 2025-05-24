@extends('layouts.base')

@section('name', 'Подтверждение почты')

@section('main')

    <div class="container">
        <div class="alert alert-info">
            Вы были зарегестрированы на сайте! Для подтверждения регистрации перейдите по ссылке, отправленной на вашу почту
        </div>

        <p>Не получили письмо?</p>
        <form action="{{ route('verification.send') }}" method="post">
            @csrf
            <button class="btn btn-primary">Отправить еще раз</button>
        </form>
    </div>

@endsection