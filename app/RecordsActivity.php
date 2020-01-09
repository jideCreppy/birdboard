<?php

namespace App;

use Illuminate\Support\Arr;


trait RecordsActivity 
{
    public $oldAttributes = [];

    public static function bootRecordsActivity()
    {
        if(isset(static::$recordableEvents)){
            $recordableEvents = static::$recordableEvents;
        }else {
            $recordableEvents = ['created', 'updated', 'deleted'];
        }

        foreach($recordableEvents as $event) {
            static::$event( function($model) use ($event) {
                $model->recordActivity($event."_".strtolower(class_basename($model)));
            });

            if($event == "updated"){
                static::updating( function ($model){
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    public function recordActivity($description)
    {
        $this->activity()->create(
            [
                'description' => $description,
                'user_id' => ($this->project ?? $this)->owner->id,
                'changes'   => $this->activityChanges(),
                'project_id' => (class_basename($this) == 'Project') ?  $this->id : $this->project_id
            ]);
    }
    
    public function activityChanges()
    {
        if($this->wasChanged()){
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' =>  Arr::except($this->getChanges(),'updated_at')
            ];
        }
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

}