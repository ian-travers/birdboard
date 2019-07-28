@php /* @var App\Project $project */ @endphp
@csrf

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title">Title</label>
    <div class="control">
        <input class="input text-muted bg-transparent border border-muted-light w-full rounded p-2 text-xs" type="text" name="title" placeholder="My awesome project" value="{{ $project->title }}" required>
    </div>
</div>
<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="description">Description</label>
    <div class="control">
        <textarea class="textarea text-muted bg-transparent border border-muted-light rounded p-2 text-xs w-full" name="description" rows="10" placeholder="I should start learning piano" required>{{ $project->description }}</textarea>
    </div>
</div>
<div class="field">
    <div class="control">
        <button type="submit" class="button is-link mr-2">{{ $btnText }}</button>
        <a href="{{ $project->path() }}">Cancel</a>
    </div>
</div>

@if ($errors->any())
    <div class="field mt-6">

        @foreach ($errors->all() as $error)
            <li class="text-sm text-red">{{ $error }}</li>
        @endforeach
    </div>
@endif