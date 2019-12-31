@extends('layouts.app')

@section('content')
<div class="container mx-auto">
   <header class="flex items-center mb-5 py-4">
        <div class="flex justify-between items-end w-full">
            <h3 class="text-gray-100 font-normal">My Projects</h3>
            <a href='projects/create' class="button">Create Project</a>
        </div>
   </header>
   <main class="lg:flex lg:flex-wrap lg:justify-between -mx-1">
       @forelse ($projects as $project)
            <div class="lg:w-1/5 px-1 pb-6">
                @include('layouts.projects.card')
            </div>

       @empty
            No projects found
       @endforelse
        </main>
    </div>
@endsection