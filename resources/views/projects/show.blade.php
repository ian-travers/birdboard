@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <h1 class="text-3xl">{{ $project->title }}</h1>
    <p>{{ $project->description }}</p>
    <div style="margin-top: 1rem;">
        <a href="/projects">Go Back</a>
    </div>
@endsection

