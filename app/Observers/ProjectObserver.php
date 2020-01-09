<?php

namespace App\Observers;

use App\Project;

class ProjectObserver
{
    /**
     * Handle the app project "created" event.
     *
     * @param  \App\Project  $appProject
     * @return void
     */
    public function created(Project $project)
    {
        $project->recordActivity('created');
    }
    
    // public function updating(Project $project)
    // {
    //     $project->old = $project->getOriginal();

    // } 

    /**
     * Handle the app project "updated" event.
     *
     * @param  \App\AppProject  $appProject
     * @return void
     */
    public function updated(Project $project)
    {
        $project->recordActivity('updated');
    }

    /**
     * Handle the app project "deleted" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        //
    }

    /**
     * Handle the app project "restored" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the app project "force deleted" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }


}
