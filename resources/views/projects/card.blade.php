@php /* @var App\Project $project */ @endphp

<div class="card flex flex-col" style="height: 236px;">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-300 pl-4 mb-3">
        <a href="{{ $project->path() }}" class="text-default">{{ $project->title }}</a>
    </h3>
    <div class="text-default mb-4 flex-1">{{ $project->description_for_card }}</div>

    @can('manage', $project)
        <footer>
            <form method="post" action="{{ $project->path() }}" class="text-right">

                @csrf
                @method('delete')
                <button type="submit" class="text-xs">Delete</button>
            </form>
        </footer>
    @endcan
</div>

