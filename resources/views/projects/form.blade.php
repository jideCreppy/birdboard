<div class="mb-8">
    <label class="block text-gray-700 text-sm font-bold mb-4" for="title">
        Project title
    </label>
    <input id="title" type="text" value="{{$project->title}}" class="bg-white focus:outline-none focus:shadow-outline border border-gray-100 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" name="title" required autofocus> 
</div>
<div class="mb-8">
    <label class="block text-gray-700 text-sm font-bold mb-4" for="description">
        Project description
    </label>
<textarea id="description" rows="10" class="bg-white focus:outline-none focus:shadow-outline border border-gray-100 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" name="description" required autofocus>
{{$project->description}}
</textarea>

</div>
<div class="mb-8">
    <button  class="button border-0" type="submit"> {{$buttonText}} </button>
    <a href="{{$project->path()}}" class="ml-2">Cancel</a>
</div>

@if($errors->any())
<div class="mt-6">
    @foreach ($errors->all() as $error)
        <li class="text-sm text-red-700"> {{$error}} </li>
    @endforeach
</div>
@endif