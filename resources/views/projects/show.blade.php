@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-3">
        <div class="flex justify-between items-end w-full">
            <p class="text-default">
                <a href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title }}
            </p>
            <div class="flex items-center">

                @foreach($project->members as $member)
                    <img src="{{ gravatar_url($member->email) }}"
                         alt="{{ $member->name }}'s avatar"
                         title="{{ $member->name }}"
                         class="inline rounded-full w-8 mr-2">
                @endforeach

                <img src="{{ gravatar_url($project->owner->email) }}"
                     alt="{{ $project->owner->name }}'s avatar"
                     title="{{ $project->owner->name }}"
                     class="inline rounded-full w-8 mr-2">
                <a class="button ml-4" href="{{ $project->path() . '/edit' }}">Edit Project</a>
            </div>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 mx-3">
                <div class="mb-8">
                    <h2 class="text-lg text-default mb-3">Tasks</h2>

                    {{--tasks--}}

                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="post" action="{{ $task->path() }}">

                                @csrf
                                @method('patch')
                                <div class="flex items-center">
                                    <input type="text" name="body" value="{{ $task->body }}"
                                           class="bg-card text-default w-full {{ $task->completed ? 'text-gray-500' : '' }}">
                                    <input type="checkbox" name="completed"
                                           onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="post">

                            @csrf
                            <input class="w-full bg-card text-default" name="body" placeholder="Add a new task...">

                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-default mb-3">General notes</h2>

                    {{--general notes--}}

                    <form action="{{ $project->path() }}" method="post">

                        @csrf
                        @method('patch')
                        <textarea
                                name="notes"
                                class="card w-full mb-2"
                                style="min-height: 200px;"
                                placeholder="Any special that you want to make a note of?"
                        >{{ $project->notes }}</textarea>
                        <button type="submit" class="button">Save</button>
                    </form>

                    @include('errors')

                </div>
            </div>

            <div class="lg:w-1/4 mx-3">

                @include('projects.card')
                @include('projects.activity.card')

                @can('manage', $project)
                    @include('projects.invite')
                @endcan
            </div>
        </div>
    </main>


@endsection

