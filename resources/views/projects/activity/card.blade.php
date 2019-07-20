<div class="card mt-3">
    <ul class="text-xs">

        @foreach($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }}">

                @include("projects.activity.{$activity->description}")
            </li>
        @endforeach
    </ul>
</div>

