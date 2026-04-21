<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/profile/update-password-form.css'])
</head>

<section>
    <header>
        <h2 class="password-title">
            {{ __('Changer le mot de passe') }}
        </h2>

        <p class="password-desc">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="password-form">
        @csrf
        @method('put')

        <div class="input-group">
            <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="input-field" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="error-msg" />
        </div>

        <div class="input-group">
            <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" />
            <x-text-input id="update_password_password" name="password" type="password" class="input-field" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="error-msg" />
        </div>

        <div class="input-group">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="input-field" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="error-msg" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-save-password">
                {{ __('Enregistrer') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="status-msg"
                >{{ __('Mot de passe mis à jour.') }}</p>
            @endif
        </div>
    </form>
</section>
