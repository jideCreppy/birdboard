@extends('layouts.app')
@section('content')
 
    <div class="container mx-auto">
        <header class="flex items-center mb-5 py-4">
            <div class="flex justify-between items-end w-full">
                <p class="text-gray-100 font-normal">
                    <a href="/projects" class="text-gray-100 no-underline font-normal">My Projects</a> / {{$project->title}}
                </p>
            <a href="{{$project->path().'/edit'}}" class="button">Edit Project</a>
            </div>
       </header>
       <main>
           <div class="lg:flex -mx-3">
               {{-- Left Sidebar --}}
                <div class="w-3/4 px-3">
                    <section class="mb-8">
                        <h3 class="text-gray-100 text-xl font-normal mb-3 mt-0">Tasks</h3>

                        {{-- Show Tasks --}}
                        @foreach ($project->tasks as $task)
                        <div class="card-show mb-4 ">
                            <form method="POST" action={{$project->path()."/tasks/".$task->id}}>
                                @method('PATCH')
                                @csrf
                                <div class="flex justify-between">
                                    <input type="text" name="body" class="w-full border-0 {{ $task->completed? 'text-gray-100' : ''}}" value="{{ $task->body }}" />
                                    <input type="checkbox" name="completed" id="complete" {{ $task->completed? 'checked' : ''}}
                                     onchange=this.form.submit()>
                                </div>
                            </form>
                        </div>
                        @endforeach
                        {{-- End Show Tasks --}}

                        {{-- Save New Task --}}
                        <form action={{$project->path()."/tasks"}} method="post">
                            <div class="card-show mb-4 ">
                                @csrf
                                <input type="text" name="body" id="body" class="w-full border-0" placeholder="Add new task..">
                            <div>
                        </form>
                        {{-- End Save New Task --}}

                    </section>
                    <section class="mb-8">
                        <h3 class="text-gray-100 text-xl font-normal mb-3">General Notes</h3>
                    <form method="POST" action="{{$project->path()}}">
                        @csrf
                        @method('PATCH')
                        <textarea name="notes" 
                        class="w-full rounded-lg text-xl"
                        style="min-height:250px"
                        placeholder="Anything special that you want to make a note of?">{{$project->notes}}</textarea>
                        <input type="submit" value="Submit" class="button border-0 mt-4">
                    </form>

                    @if($errors->any())
                        <div class="mt-6">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-700"> {{$error}} </li>
                            @endforeach
                        </div>
                    @endif
                    
                    </section>
                </div>
                {{-- Right side bar --}}
                <aside class="w-1/4 px-3 mt-8">
                    @include('layouts.projects.card')
                    @include('layouts.activity.card')
                </aside>
           </div>
       </main>
    </div>
@endsection
