@props(['job', 'index'])

<div class="task-card">
    <div class="task-info">
        <span class="task-number">#{{ $index }}</span>
        <strong class="task-name">{{ $job->name }}</strong>
        <span class="task-file">
            <i class="fas fa-file-code"></i> {{ $job->stl_filename }}
        </span>
    </div>
    <div class="task-status">
        <span class="status-label">{{ __('home.state_job') }}</span>
        <x-card-state-job :color="$job->status_color" :text="$job->name_state" />
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('jobs.edit', $job) }}" class="btn-edit">
                <i class="fas fa-edit"></i>
            </a>
        @endif
    </div>
    <div class="task-actions">
        <form action="{{ route('jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('{{ __('home.confirm_delete_job') }}');">
            @csrf
            @method('DELETE') 
            <button type="submit" class="btn-delete ">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>  
</div>