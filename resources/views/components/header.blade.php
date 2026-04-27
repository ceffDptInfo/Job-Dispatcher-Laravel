<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/header.css', 'resources/js/app.js'])
</head>

<header class="main-header">
    <div class="div-header">
        <h1 class="header-title">
            <a href="{{ route('home') }}" style="header-title">
                {{ __('header.name_app_header') }}
            </a>
        </h1>

        <div>
            @auth
                <div class="relative group" style="padding: 10px 0;">
                    <button class="profile-circle">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </button>

                    <div class="box-logout">
                        <div class="box-text">{{ Auth::user()->name }}</div>

                        <div class="lang-selector">
                            <a href="{{ route('lang.switch', 'fr') }}"
                                class="lang-link {{ app()->getLocale() == 'fr' ? 'active' : '' }}">FR</a>
                            <span style="color: #e5e7eb;">|</span>
                            <a href="{{ route('lang.switch', 'en') }}"
                                class="lang-link {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="btn-profile">
                            {{ __('header.my_account_header') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn-header">
                                {{ __('header.log_out_header') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>
