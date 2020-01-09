<div class="card mt-3 text-sm overflow-y-auto">
    @foreach ($project->activity as $activity)
    <div class="{{$loop->last ? '' : 'mb-2'}}">
        {{-- @if($activity->description == "created")
           @include('layouts.activity.created') --}}
        @if($activity->description == "created_task")
            @include('layouts.activity.created_task')
        @elseif($activity->description == "updated_task")
            @include('layouts.activity.updated')
        @elseif($activity->description == "completed_task")
            @include('layouts.activity.completed_task')
        @elseif($activity->description == "incompleted_task")
            @include('layouts.activity.incompleted_tasks')
        @elseif($activity->description == "updated_project")
            @include('layouts.activity.updated_project')
        @elseif($activity->description == "created_project")
        @include('layouts.activity.created_project')
        @endif
        <span class="text-gray-100 text-sm">{{ $activity->updated_at->diffForHumans(null, true) }} </span>
    </div>
    @endforeach
</div>