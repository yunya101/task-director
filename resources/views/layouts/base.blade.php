<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>@yield('name')</title>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-primary navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('groups.index') }}">Task Composer</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @if (Auth::user() !== null)
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('groups.create') }}">Создать группу</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('groups.index') }}">Мои группы</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('invitations.index') }}">Уведомления</a>
                        </li>
                    </ul>
                    <form action="{{ route('login.logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn">Выйти</button>
                    </form>
                @endif
            </div>
        </nav>
    </header>

    <main class="mt-5">
        @if ($errors->any())

            <div class="container">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach
                    </ul>
                </div>
            </div>

        @endif
        @yield('main')
    </main>


    <footer class="bg-primary b-auto fixed-bottom">
        <div class="container">
            <div class="row">footer</div>
        </div>
    </footer>

    <style>
        body html {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>