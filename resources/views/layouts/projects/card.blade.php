<div class="card">
    <a href="{{$project->path()}}" class="text-black no-underline">
        <h3 class="font-normal border-custom-left text-2xl py-4 mb-3 -ml-5 pl-4"> {{$project->title}}</h3>
    </a>
    <div class="text-gray-100">{{ str_limit($project->description,100)}}</div>
</div>