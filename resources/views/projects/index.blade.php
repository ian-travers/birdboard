@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-3">
        <div class="flex w-full items-end justify-between">
            <h2>My Projects</h2>
            <div class="flex">
                <a class="button" href="{{ route('projects.create') }}">Add Project</a>
                <a class="button ml-3" href="" @click.prevent="$modal.show('new-project')">Add Project Modal</a>
            </div>
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

    <new-project-modal></new-project-modal>
@endsection