@extends('layouts.app')

@section('content')
<div class="container mx-auto">
   <header class="flex items-center mb-5 py-4">
        <div class="flex justify-between items-end w-full">
            <h3 class="text-gray-100 font-normal">My Projects</h3>
            <a href='/projects/create' class="button">Create Project</a>
        </div>
   </header>
   <main class="lg:flex lg:flex-wrap -mx-3">
       @forelse ($projects as $project)
   <div class="px-1 w-1/3 px-2 pb-4">
                @include('layouts.projects.card')
            </div>
       @empty
            No projects found
       @endforelse
        </main>
    </div>
@endsection