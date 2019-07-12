@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>BirdBoard</h1>

        @forelse($projects as $project)
            <ul>
                <li><a href="{{ $project->path() }}">{{ $project->title }}</a></li>
            </ul>
        @empty
            <p>There is not projects yet.</p>
        @endforelse
    </div>

@endsection