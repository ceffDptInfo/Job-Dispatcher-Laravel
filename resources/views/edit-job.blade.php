<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/create-job.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="div-login" x-data="{ fileName: '{{ $job->stl_filename }}', isDragging: false, error: '' }">
        <x-header/>
        <div class="div-center">
            <div class="w-full max-w-4xl">          
                <form action="{{ route('jobs.update', $job) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-10 flex flex-col items-center">
                        <label for="name" class="name-project">{{ __('editJob.name_project_editJob') }}</label>
                        <input type="text" name="name" id="name" class="input-style" value="{{ old('name', $job->name) }}">
                    </div>
                    <div class="mb-10">
                        <label for="stl_filename" class="drop-zone"
                            :class="{
                                'border-green-500 bg-gray-50/20': fileName && !error,
                                'border-red-500 bg-red-50/20': error,
                                'border-gray-400 bg-gray-50/20': !isDragging && !fileName && !error
                            }"
                            @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="
                                isDragging = false; 
                                let file = $event.dataTransfer.files[0];
                                if (file && file.name.toLowerCase().endsWith('.stl')) {
                                    fileName = file.name;
                                    error = '';
                                    $refs.fileInput.files = $event.dataTransfer.files;
                                } else {
                                    fileName = '';
                                    error = '{{ __('editJob.unauthorized_file_format_editJob') }}';
                                }
                            ">
                            <input type="file" name="stl_filename" x-ref="fileInput" class="hidden" id="stl_filename" accept=".stl"
                                   @change="
                                   let file = $event.target.files[0];
                                   if (file && file.name.toLowerCase().endsWith('.stl')) {
                                       fileName = file.name;
                                       error = '';
                                   } else {
                                       fileName = '';
                                       error = 'Le format n\'est pas autorisé';
                                   }">
                            <div class="text-center w-full">
                                <div class="mb-4 h-16 flex items-center justify-center">
                                    <template x-if="!fileName && !error">
                                        <svg class="w-16 h-16 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </template>
                                    <template x-if="fileName">
                                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </template>
                                    <template x-if="error">
                                        <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </template>
                                </div>
                                <h3 class="text-xl font-semibold mb-2">
                                    <span x-show="fileName" class="text-green-600">{{ __('editJob.file_text_editJob') }} <span x-text="fileName"></span></span>
                                    <span x-show="error" class="text-red-500" x-text="error"></span>
                                </h3>
                            </div>
                        </label>
                    </div>
                    <div class="flex flex-col items-center mb-12">
                        <div class="flex flex-col items-center gap-2 w-full justify-center">
                            <label class="name-project">{{ __('editJob.profile_text_editJob') }}</label>
                            <select name="id_slicer_profile" class="dropdown-menu">
                                @foreach([1 => 'Blanc, PLA', 2 => 'Blanc, PETG', 3 => 'Noir, ABS', 4 => 'Noir, Nylon'] as $id => $label)
                                    <option value="{{ $id }}" {{ $job->id_slicer_profile == $id ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col items-center mb-12">
                        <div class="flex flex-col items-center gap-2 w-full justify-center">
                            <label class="name-project">{{ __('editJob.state_text_editJob') }}</label>
                            <select name="name_state" class="dropdown-menu">
                                <option value="error_printing" {{ $job->name_state == 'error_printing' ? 'selected' : '' }}>Error_printing</option>
                                <option value="error_slicing" {{ $job->name_state == 'error_slicing' ? 'selected' : '' }}>Error_slicing</option>
                                <option value="finished" {{ $job->name_state == 'finished' ? 'selected' : '' }}>Finished</option>
                                <option value="printing" {{ $job->name_state == 'printing' ? 'selected' : '' }}>Printing</option>
                                <option value="sliced" {{ $job->name_state == 'sliced' ? 'selected' : '' }}>Sliced</option>
                                <option value="waiting" {{ $job->name_state == 'waiting' ? 'selected' : '' }}>Waiting</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                         <x-link-button-style href="{{ route('home') }}">{{ __('editJob.cancel_button_editJob') }}</x-link-button-style>
                         <button type="submit" class="btn">{{ __('editJob.edit_button_editJob') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>