<header class="main-header">
    <div class="div-header">
        <h1 class="header-title"><a href="{{ route('home') }}">Job Dispatcher</a></h1>
        <div>
            @auth
                <div class="relative group py-2">
                    <button class="profile-circle">{{ substr(Auth::user()->name, 0, 1) }}</button>
                    <div class="box-logout">
                        <div class="box-text">{{ Auth::user()->name }}</div>
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