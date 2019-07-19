@extends('layouts.app')

@section('content')
    <div class="bg-white lg:w-1/2 lg:mx-auto py-12 px-16 rounded shadow">
        <h1 class="mb-10 text-2xl text-center font-normal">Let's start something new</h1>
        <form method="post" action="/projects">

            @include('projects._form', [
                'project' => new App\Project(),
                'btnText' => 'Create Project',
            ])

        </form>
    </div>
@endsection

