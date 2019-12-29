@extends('layouts.app')

@section('content')
<div class="container">
   <div class="flex items-center mb-5">
        <h1 class="mr-auto text-2xl">Welcome</h1>
        <a href='projects/create'>Create Project</a>
   </div>
    @forelse ($projects as $project)
     <ul>
         <li>
             <a href="{{$project->path()}}">{{$project->title}}</a>
        </li>
     </ul>
     @empty
         No Project Found
    @endforelse
</div>
@endsection