@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-3">
        <div class="flex w-full items-center justify-between">
            <h2>My Projects</h2>
            <a class="button" href="/projects/create">Add Project</a>
        </div>
    </header>

    <main class="flex flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="w-1/3 px-3 pb-6">
                <div class="bg-white p-5 rounded shadow" style="height: 200px;">
                    <h3 class="font-normal text-xl py-4">{{ $project->title }}</h3>
                    <div class="text-gray-500">{{ Str::limit($project->description, 120) }}</div>
                </div>
            </div>

        @empty
            <div>There is not projects yet.</div>
        @endforelse
    </main>
@endsection