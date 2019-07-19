@php /* @var App\Project $project */ @endphp

@extends('layouts.app')

@section('content')
    <div class="bg-white lg:w-1/2 lg:mx-auto py-12 px-16 rounded shadow">
        <h1 class="mb-10 text-2xl text-center font-normal">Edit your project</h1>
        <form method="post" action="{{ $project->path() }}">

            @method('patch')
            @include('projects._form', [
                'btnText' => 'Update Project',
            ])

        </form>
    </div>
@endsection

