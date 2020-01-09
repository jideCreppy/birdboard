@extends('layouts.app')
@section('content')
<div class="w-full">
    <div class="card-show h-auto w-1/3 mx-auto">
        <form action="{{$project->path()}}" method="POST">
            @csrf
            @method('PATCH')
            <h1 class="mb-10 text-center text-gray-600">Edit Your Project</h1>
            @include('projects.form' , ['buttonText' => 'Update Project'])
        </form>
        </div>
    </div>
</div>
@endsection