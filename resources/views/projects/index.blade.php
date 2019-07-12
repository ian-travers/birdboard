@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>BirdBoard</h1>

        @forelse($projects as $project)
            <ul>
                <li>{{ $project->title }}</li>
            </ul>
        @empty
            <p>There is not projects yet.</p>
        @endforelse
    </div>

@endsection