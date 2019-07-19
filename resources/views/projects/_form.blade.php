@php /* @var App\Project $project */ @endphp

<form method="post" action="{{ $project->path() }}" class="bg-white lg:w-1/2 lg:mx-auto py-12 px-16 rounded shadow">

    @csrf
    @method('patch')
    <h1 class="mb-10 text-2xl text-center font-normal">Edit your project</h1>
    <div class="field mb-6">
        <label class="label text-sm mb-2 block" for="title">Title</label>
        <div class="control">
            <input class="input bg-transparent border border-gray-300 w-full rounded p-2 text-xs" type="text" name="title" placeholder="Title" value="{{ $project->title }}">
        </div>
    </div>
    <div class="field mb-6">
        <label class="label text-sm mb-2 block" for="description">Description</label>
        <div class="control">
            <textarea class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full" name="description" rows="10" placeholder="I should start learning piano">{{ $project->description }}</textarea>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link mr-2">Update Project</button>
            <a href="{{ $project->path() }}">Cancel</a>
        </div>
    </div>
</form>