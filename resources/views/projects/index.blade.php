@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <div class="flex items-center mb-4">
        <a href="/projects/create">Create New Project</a>
    </div>
    <div class="flex">
        @forelse($projects as $project)
            <div class="bg-white p-5 mr-4 rounded shadow w-1/3" style="height: 200px;">
                <h3 class="font-normal text-xl py-4">{{ $project->title }}</h3>
                <div class="text-gray-500">{{ Str::limit($project->description, 120) }}</div>
            </div>
        @empty
            <div>There is not projects yet.</div>
        @endforelse
    </div>
@endsection