<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/login/verify-email.css', 'resources/js/app.js'])
</head>

<body class="main-wrapper">

    <div class="verify-card">

        <div class="verify-title">
            {{ __('Vérifiez votre adresse e-mail') }}
        </div>

        <div class="verify-desc">
            {{ __("Merci de votre inscription ! Avant de commencer, pourriez-vous s'il vous plait vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer ?") }}
        </div>

        
        <div class="verify-actions">
            <form method="POST" action="{{ route('verification.send') }}" style="width: 100%;">
                @csrf
                <button type="submit" class="btn-resend">
                    {{ __('Renvoyer l\'e-mail de vérification') }}
                </button>
            </form>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    {{ __('Déconnexion') }}
                </button>
            </form>
        </div>
        @if (session('status') == 'verification-link-sent')
            <div class="status-success">
                {{ __('Un nouveau lien de vérification a été envoyé.') }}
            </div>
        @endif
    </div>

</body>