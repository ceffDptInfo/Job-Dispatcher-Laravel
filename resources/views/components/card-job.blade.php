@props(['job', 'index'])

<div class="task-card">
    <div class="task-main-row">
        <div class="task-info">
            <span class="task-number">#{{ $index }}</span>
            <strong class="task-name">{{ $job->name }}</strong>
            <span class="task-file">
                <i class="fas fa-file-code"></i> {{ $job->stl_filename }}
            </span>
        </div>
        <div class="task-status">
            <x-card-state-job :color="$job->state->color" :text="$job->state->name" />
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('jobs.edit', $job) }}" class="btn-edit">
                    <i class="fas fa-edit"></i>
                </a>
            @endif
        </div>
        <div class="task-actions">
            <form action="{{ route('jobs.destroy', $job) }}" method="POST"
                onsubmit="return confirm('{{ __('home.confirm_delete_job') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="job-tags-list">
        @foreach ($job->tags as $tag)
            @if ($tag)
                <span class="tag-badge">
                    {{ $tag->name }}
                    <form action="{{ route('jobs.tags.destroy', ['job' => $job->id_job, 'tag' => $tag->id_tag]) }}"
                        method="POST" class="tag-delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Retirer ce tag ?')" class="btn-tag-remove">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </form>
                </span>
            @endif
        @endforeach
        <a href="{{ route('jobs.tags.create', $job->id_job) }}" class="btn-add-tag">
            <i class="fas fa-plus-circle"></i>
        </a>
    </div>
</div>
