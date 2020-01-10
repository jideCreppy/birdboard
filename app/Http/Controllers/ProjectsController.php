<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects =  auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {   
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
       $attributes =  request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes'  =>  'max:255'
        ]);
        
        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function update(Project $project)
    {  
        $this->authorize('update', $project);

        $attributes =  request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes'  =>  'nullable'
        ]);


        $project->update($attributes);

        return redirect($project->path());
    }
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function destroy(Project $project)
    {
        $this->authorize('update', $project);
        $project->delete();
        return  redirect('/projects');
    }




}
