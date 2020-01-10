<div class="card">
    <a href="{{$project->path()}}" class="text-black no-underline">
        <h3 class="font-normal border-custom-left text-2xl py-4 mb-3 -ml-5 pl-4"> {{$project->title}}</h3>
    </a>
    <div class="text-gray-100">{{ str_limit($project->description,100)}}</div>
    <form method="POST" action="{{$project->path()}}" class="text-right mt-16">
        @method("DELETE")
        @csrf
        <button href="" class="bg-white border-0 text-sm text-gray-100 cursor-pointer"><i class="fas fa-trash"></i></button>
    </form>
</div>