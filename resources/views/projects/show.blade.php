@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-3">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-500">
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
                    <h2 class="text-lg text-gray-600 mb-3">Tasks</h2>

                    {{--tasks--}}

                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="post" action="{{ $task->path() }}">

                                @csrf
                                @method('patch')
                                <div class="flex items-center">
                                    <input type="text" name="body" value="{{ $task->body }}"
                                           class="w-full {{ $task->completed ? 'text-gray-500' : '' }}">
                                    <input type="checkbox" name="completed"
                                           onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="post">

                            @csrf
                            <input class="w-full" name="body" placeholder="Add a new task...">

                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-gray-600 mb-3">General notes</h2>

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

                <div class="card flex flex-col mt-3">
                    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-300 pl-4 mb-3">
                        Invite a User
                    </h3>
                    <form method="post" action="{{ $project->path() . '/invitations' }}">

                        @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="border border-gray-400 rounded w-full py-2 px-3" placeholder="Email address">
                        </div>
                        <button type="submit" class="button">Invite</button>
                    </form>

                    @include('errors', ['bag' => 'invitations'])
                </div>
            </div>
        </div>
    </main>


@endsection

