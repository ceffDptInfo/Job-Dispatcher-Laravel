<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="main-wrapper">
        <x-header/>
        <main class="content-container">
            <div class="div2-home">
                <h2>Vos jobs</h2>
                <div class="actions-header">
                    <a href="{{ route('jobs.create') }}" class="btn-add">Ajouter un job</a>
                </div>
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
                            <span class="status-text">{{ $job->name_state }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</body>
</html>