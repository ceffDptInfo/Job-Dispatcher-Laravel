<!DOCTYPE html>
<html lang="fr">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/create-job.css', 'resources/js/app.js'])
</head>
 
<body class="antialiased">
    <div class="div-login" x-data="{ fileName: '', isDragging: false, error: '' }">
        <x-header />
        <div class="div-center">
            <div class="w-full max-w-4xl">
                <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-10 flex flex-col items-center">
                        <label for="name" class="name-project">{{ __('createJob.name_create_job') }}</label>
                        <input type="text" name="name" id="name" class="input-style">
                    </div>
                    <div class="mb-10">
                        <label for="inputfile" class="drop-zone"
                            :class="{
                                'border-green-500 bg-gray-50/20': fileName && !error,
                                'border-red-500 bg-red-50/20': error,
                                'border-gray-400 bg-gray-50/20': !isDragging && !fileName && !error
                            }"
                            @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                            @drop.prevent="
                            isDragging = false;
                            let file = $event.dataTransfer.files[0];
                            if (file && file.name.toLowerCase().endsWith('.stl')) {
                                fileName = file.name;
                                error = '';
                                $refs.fileInput.files = $event.dataTransfer.files;
                            } else {
                                fileName = '';
                                error = 'Le format n\'est pas autorisé (.STL seulement)';
                            }">
                            <input type="file" name="inputfile" x-ref="fileInput" class="hidden" id="inputfile"
                                accept=".stl"
                                @change="
                               let file = $event.target.files[0];
                               if (file && file.name.toLowerCase().endsWith('.stl')) {
                                   fileName = file.name;
                                   error = '';
                                }">
                            <div class="text-center w-full">
                                <div class="mb-4 h-16 flex items-center justify-center">
                                    <template x-if="!fileName && !error">
                                        <svg class="w-16 h-16 text-white opacity-90" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </template>
                                    <template x-if="fileName">
                                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </template>
                                    <template x-if="error">
                                        <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </template>
                                </div>
                                <h3 class="text-xl font-semibold mb-2">
                                    <span x-show="!fileName && !error"
                                        class="text-white">{{ __('createJob.text_file_create_job') }}</span>
                                    <span x-show="fileName"
                                        class="text-green-600">{{ __('createJob.file_ready_create_job') }}</span>
                                    <span x-show="error"
                                        class="text-red-600">{{ __('createJob.error_format_create_job') }}</span>
                                </h3>
                                <div class="h-6">
                                    <span x-show="fileName" x-text="fileName"
                                        class="text-sm text-gray-500 font-mono italic"></span>
                                    <span x-show="error" x-text="error" class="text-sm text-red-500 font-bold"></span>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="flex flex-col items-center mb-12">
                        <div class="flex flex-col items-center gap-2 w-full justify-center">
                            <label class="name-project">{{ __('createJob.profil_select_create_job') }}</label>
                            <select name="id_slicer_profile" class="dropdown-menu">
                                <option value="1">Blanc, PLA</option>
                                <option value="2">Blanc, PETG</option>
                                <option value="3">Noir, ABS</option>
                                <option value="4">Noir, Nylon</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                        <x-link-button-style
                            href="{{ route('home') }}">{{ __('createJob.bouton_cancel_create_job') }}</x-link-button-style>
                        <button type="submit" class="btn"
                            :disabled="!fileName">{{ __('createJob.bouton_start_create_job') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
