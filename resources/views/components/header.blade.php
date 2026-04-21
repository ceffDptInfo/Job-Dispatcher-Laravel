<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/header.css'])
</head>

<header class="main-header">
    <div class="div-header">
        <h1 class="header-title"><a href="{{ route('home') }}">Job Dispatcher</a></h1>
        <div>
            @auth
                <div class="relative group py-2">
                    <button class="profile-circle">{{ substr(Auth::user()->name, 0, 1) }}</button>
                    <div class="box-logout">
                        <div class="box-text">{{ Auth::user()->name }}</div>
                        <a href="{{ route('profile.edit') }}" class="btn-profile">Mon profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-header">Se déconnecter</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>