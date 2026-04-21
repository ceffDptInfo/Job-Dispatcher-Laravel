<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/home.css', 'resources/js/app.js'])
</head>

<body>
    <div class="main-wrapper">
        <x-header />
        <main class="content-container">
            <div class="div2-home">
                <h2 class="title-home">Vos jobs</h2>
                <x-link-button-style href="{{ route('jobs.create') }}">Ajouter</x-link-button-style>
            </div>

            <div class="tasks-list">
                @foreach ($jobs as $job)
                    <div class="task-card">
                        <div class="task-info">
                            <span class="task-number">#{{ $loop->iteration }}</span>
                            <strong class="task-name">{{ $job->name }}</strong>
                            <span class="task-file">
                                <i class="fas fa-file-code"></i> {{ $job->stl_filename }}
                            </span>
                        </div>

                        <div class="task-status">
                            <span class="status-label">Status :</span>
                            {{-- <span>{{ config('app.slicer_path') }}</span> --}}
                        </div>
                        <div>
                            <x-card-state-job :color="$job->status_color" :text="$job->name_state" />
                        </div>

                    </div>
                @endforeach
            </div>
        </main>
    </div>
</body>

</html>
