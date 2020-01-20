@can('manage', $project)
    <div class="card mt-4">
        <h3 class="font-normal border-custom-left text-2xl py-4 -ml-5 pl-4 mb-3"> Invite Users</h3>
        <form method="POST" action="{{$project->path()."/invitations"}}" class="">
            @csrf
            <input type="email" name="email" class="py-1 w-full mb-5" />
            <button type="submit" class="button border-0">Invite</button>
        </form>
        @include('errors', ['bag' => 'invitations'])
    </div>
@endCan

