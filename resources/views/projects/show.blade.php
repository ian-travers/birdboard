@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-3">
        <div class="flex w-full items-end justify-between">
            <h2>My Projects</h2>
            <a class="button" href="/projects/create">Add Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 mx-3">
                <div class="mb-6">
                    <h2 class="text-lg text-gray-600 mb-3">Tasks</h2>
                    {{--tasks--}}
                    <div class="card">Lorem ipsum dolor.</div>
                </div>

                <div>
                    <h2 class="text-lg text-gray-600 mb-3">General Notes</h2>
                    {{--general notes--}}
                    <div class="card">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto beatae cumque deleniti deserunt eius est illo in iure laboriosam magnam magni maiores minima minus molestiae neque nulla quae, quis quisquam vel voluptatibus. Suscipit!
                    </div>
                </div>

            </div>
            <div class="lg:w-1/4 mx-3">
                <div class="card">
                    <h1 class="text-3xl">{{ $project->title }}</h1>
                    <p>{{ $project->description }}</p>
                    <div style="margin-top: 1rem;">
                        <a href="/projects">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection

