<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\User;
use App\Project;
use Illuminate\Http\Request;

class ProjectInvitationsController extends Controller
{
    public function store(Project $project, InvitationRequest $invitation){
        $user = User::whereEmail(request('email'))->first();
        $project->invite($user);

        return redirect($project->path());
    }
}
