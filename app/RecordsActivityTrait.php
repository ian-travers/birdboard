<?php

namespace App;


use Illuminate\Support\Arr;

trait RecordsActivityTrait
{
    /**
     * The model's old attributes
     *
     * @var array
     */
    public $oldAttributes = [];

    /**
     * Boot the trait
     */
    public static function bootRecordsActivityTrait()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {

                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    protected function activityDescription($description)
    {
        return "{$description}_" . strtolower(class_basename($this));
    }

    /**
     * @return array
     */
    protected static function recordableEvents(): array
    {
        if (isset(static::$recordableEvents)) {
            return $recordableEvents = static::$recordableEvents;
        }

        return $recordableEvents = ['created', 'updated', 'deleted'];
    }

    /**
     * Record activity for a model
     *
     * @param $description
     */
    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id' => $this->activityOwner()->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }

    protected function activityOwner()
    {
        if (auth()->check()) {
            return auth()->user();
        }

        if (class_basename($this) === 'Project') {
            return $this->owner;
        }

        return $this->project->owner;
    }

    /**
     * Fetch the changes to the model
     *
     * @return array|null
     */
    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }

    /**
     * The activity feed for the model
     *
     * @return mixed
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}