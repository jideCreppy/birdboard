<?php

namespace App;

use App\Task;
use App\User;
use App\Activity;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {

        $project = $this->tasks()->create($body);
        return $project;
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function recordActivity($type)
    {
        Activity::create(
            [
                'project_id' => $this->id, 
                'description' => $type
            ]);
    }
}

