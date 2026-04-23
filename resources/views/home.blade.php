<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/home.css', 'resources/js/app.js'])
</head>

<body>
    <div class="main-wrapper">
        <x-header />
        <main class="content-container">
            <div class="div2-home">
                <h2 class="title-home">{{ __('home.title_jobs') }}</h2>
                <x-link-button-style href="{{ route('jobs.create') }}">{{ __('home.add_job') }}</x-link-button-style>
            </div>
            <div class="tasks-list">
                @foreach ($jobs as $job)
                    <x-card-job :job="$job" :index="$loop->iteration" />
                @endforeach
            </div>
        </main>
    </div>
</body>
</html>
