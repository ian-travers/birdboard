@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $project->title }}</h1>
        <p>{{ $project->description }}</p>
        <div style="margin-top: 1rem;">
            <a href="/projects">Go Back</a>
        </div>
    </div>
@endsection

