@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex items-center mb-4">
            <h1 class="mr-auto h1">BirdBoard</h1>
            <a href="/projects/create">Create New Project</a>
        </div>

        @forelse($projects as $project)
            <ul>
                <li><a href="{{ $project->path() }}">{{ $project->title }}</a></li>
            </ul>
        @empty
            <p>There is not projects yet.</p>
        @endforelse
    </div>
@endsection