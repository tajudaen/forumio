<?php

namespace App\Traits;

use App\Activity;

trait RecordsActivity
{
    protected function recordActivity($event)
    {
        Activity::create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
            'subject_id' => $this->id,
            'subject_type' => get_class($this)
        ]);
    }

    protected function getActivityType($event)
    {
        return "{$event}_" . strtolower((new \ReflectionClass($this))->getShortName());
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }
}
