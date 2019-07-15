@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <div class="flex items-center mb-4">
        <a href="/projects/create">Create New Project</a>
    </div>
    <div class="flex">
        @forelse($projects as $project)
            <div class="bg-white mr-4 rounded shadow">
                <h3 class="text-xl">{{ $project->title }}</h3>
                <div>{{ $project->description }}</div>
            </div>
        @empty
            <div>There is not projects yet.</div>
        @endforelse
    </div>
@endsection