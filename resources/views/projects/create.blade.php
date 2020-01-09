@extends('layouts.app')
@section('content')
<div class="w-full">
    <div class="card-show h-auto w-1/3 mx-auto">
        <form action="/projects" method="POST">
            @csrf
            <h1 class="mb-10 text-center text-center text-gray-600">Lets start something new...</h1>
            @include('projects.form' , [
                'buttonText' => 'Create Project',
                'project'   =>  new App\Project
                ])
        </form>
    </div>
</div>
@endsection