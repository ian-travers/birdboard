@php /* @var App\Project $project */ @endphp

<div class="card mt-3">
    <ul class="text-xs">

        @foreach($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }}">

                @include("projects.activity.{$activity->description}")
                <span class="text-gray-500">{{ $activity->created_at->from(null, true) }}</span>
            </li>
        @endforeach
    </ul>
</div>

