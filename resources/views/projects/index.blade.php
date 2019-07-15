@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-3">
        <div class="flex w-full items-end justify-between">
            <h2>My Projects</h2>
            <a class="button" href="/projects/create">Add Project</a>
        </div>
    </header>

    <main class="lg:flex flex-wrap -mx-3">

        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div>There is not projects yet.</div>
        @endforelse
    </main>
@endsection