<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/profile/update-profile-information-form.css'])
</head>

<section class="profile-section">
    <header>
        <h2 class="profile-title">
            {{ __('Votre profil') }}
        </h2>
        <p class="profile-desc">
            {{ __('Mettez à jour les informations de votre profil et votre adresse email.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('patch')

        <div class="input-group">
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" name="name" type="text" class="input-field" :value="old('name', $user->name)" required
                autofocus autocomplete="name" />
            <x-input-error class="error-msg" :messages="$errors->get('name')" />
        </div>

        <div class="input-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="input-field" :value="old('email', $user->email)" required
                autocomplete="username" />
            <x-input-error class="error-msg" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="verification-alert">
                    <p class="profile-desc">
                        {{ __('Votre nouvelle adresse e-mail n\'est pas vérifiée ;') }}
                        <button form="send-verification" type="submit" class="btn-link">
                            {{ __('Cliquez ici pour envoyer l\'e-mail de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <span class="status-msg-alert">
                            {{ __('Un nouveau lien a été envoyé à votre adresse.') }}
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save-profile-name">
                {{ __('Enregistrer') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="status-msg">
                    {{ __('Informations du profil mises à jour.') }}</p>
            @endif
        </div>
    </form>
</section>
