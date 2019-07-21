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
                if (class_basename($model) !== 'Project') {
                    $event = "{$event}_" . strtolower(class_basename($model));
                }

                $model->recordActivity($event);
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
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
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
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