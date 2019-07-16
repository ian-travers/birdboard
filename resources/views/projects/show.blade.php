@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-3">
        <div class="flex w-full items-end justify-between">
            <p class="text-gray-500">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>
            <a class="button" href="/projects/create">Add Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 mx-3">
                <div class="mb-8">
                    <h2 class="text-lg text-gray-600 mb-3">Tasks</h2>
                    {{--tasks--}}

                    @forelse($project->tasks as $task)
                        <div class="card">{{ $task->body }}</div>
                    @empty
                        <div>It has not tasks yet.</div>
                    @endforelse
                </div>

                <div>
                    <h2 class="text-lg text-gray-600 mb-3">General Notes</h2>
                    {{--general notes--}}
                    <textarea class="card w-full" style="min-height: 200px;">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto beatae cumque deleniti deserunt eius est illo in iure laboriosam magnam magni maiores minima minus molestiae neque nulla quae, quis quisquam vel voluptatibus. Suscipit!
                    </textarea>
                </div>

            </div>
            <div class="lg:w-1/4 mx-3">

                @include('projects.card')
            </div>
        </div>
    </main>


@endsection

