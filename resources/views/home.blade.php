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
            <div class="space-home">
                <div class="row-title">
                    <h1 class="title-home">{{ __('home.title_jobs') }}</h1>
                    <x-link-button-style href="{{ route('jobs.create') }}">
                        {{ __('home.add_job') }}
                    </x-link-button-style>
                </div>
                <div>
                    <form id="sortForm" action="{{ url()->current() }}" method="GET">
                        <x-dropdown label="{{ __('home.title_filter_jobs') }}" name="filter" :options="array_merge(
                            [
                                '' => __('home.filter_last_created_jobs'),
                                'abc' => __('home.filter_az_jobs'),
                                'cba' => __('home.filter_za_jobs'),
                                'waiting' => __('home.filter_state_waiting_jobs'),
                                'printing' => __('home.filter_state_printing_jobs'),
                                'finished' => __('home.filter_state_completed_jobs'),
                                'sliced' => __('home.filter_state_sliced_jobs'),
                                'error_printing' => __('home.filter_state_error_printing_jobs'),
                                'error_slicing' => __('home.filter_state_error_slicing_jobs'),
                            ],
                            $tags
                                ->pluck('name', 'id_tag')
                                ->mapWithKeys(function ($name, $id) {
                                    return ['tag_' . $id => 'Tag : ' . $name];
                                })
                                ->toArray(),
                        )" :selected="request('filter')"
                            onchange="document.getElementById('sortForm').submit()" />
                    </form>
                </div>
                <div class="tasks-list">
                    @foreach ($jobs as $job)
                        <x-card-job :job="$job" :index="$loop->iteration" />
                    @endforeach
                </div>

            </div>
        </main>
</body>

</html>
