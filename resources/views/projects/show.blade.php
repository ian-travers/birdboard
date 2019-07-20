@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-3">
        <div class="flex w-full items-end justify-between">
            <p class="text-gray-500">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>
            <a class="button" href="{{ $project->path() . '/edit' }}">Edit Project</a>
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

                    @if ($errors->any())
                        <div class="field mt-6">

                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-500">{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:w-1/4 mx-3">

                @include('projects.card')

                <div class="card mt-3">
                    <ul class="text-xs">

                        @foreach($project->activity as $activity)
                            <li class="{{ $loop->last ? '' : 'mb-1' }}">

                                @include("projects.activity.{$activity->description}")
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </main>


@endsection

