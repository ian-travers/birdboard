@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create a Project</h1>
        <form method="post" action="/projects">
            @csrf
            
            <div>
                <label style="display: block;" for="title">Title</label>
                <input style="display: block;" type="text" name="title" placeholder="Title">
            </div>

            <div>
                <label style="display: block;" for="description">Description</label>
                <textarea style="display: block; margin-bottom: 1rem;" name="description" rows="6"></textarea>
            </div>
            <button type="submit">Create Project</button>
            <a href="/projects">Cancel</a>
        </form>
    </div>
@endsection

