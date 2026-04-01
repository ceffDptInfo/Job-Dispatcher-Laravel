<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Job Dispatcher</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="div-login">
    <x-header/> 
        <div class="flex flex-1 items-center justify-center">
            <div class="w-full max-w-xl text-center">
                <h2 class="text-3xl font-bold mb-10">Connection</h2>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="flex items-center mb-6">
                        <label class="label-login">Email :</label>
                        <div class="w-2/3">
                            <input type="email" name="email" value="{{ old('email') }}" required class="input-login">
                            @error('email')
                                <p class="text-red-400 text-sm mt-1 text-left">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center mb-6">
                        <label class="label-login">Mot de passe :</label>
                        <div class="w-2/3">
                            <input type="password" name="password" required class="input-login">
                            @error('password')
                                <p class="text-red-400 text-sm mt-1 text-left">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-start mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-indigo-600">
                            <span class="text-sm">Se souvenir de moi</span>
                        </label>
                    </div>
                    <button type="submit" class="btn-login">Confirmer</button>
                </form>
                <div class="mt-10">
                    <p>Vous n’avez pas encore de compte ?</p>
                    <a href="{{ route('register') }}" class="href-login">Inscrivez-vous ici</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>