@php /* @var App\Project $project */ @endphp

<div class="card flex flex-col" style="height: 236px;">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-300 pl-4 mb-3">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h3>
    <div class="text-gray-500 mb-4 flex-1">{{ $project->description_for_card }}</div>
    <footer>
        <form method="post" action="{{ $project->path() }}" class="text-right">

            @csrf
            @method('delete')
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>
</div>

