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

        return $recordableEvents = ['created', 'updated'];
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
        return auth()->check() ? auth()->user() : ($this->project ?? $this)->owner;
//        if (auth()->check()) {
//            return auth()->user();
//        }
//        return ($this->project ?? $this)->owner;
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

        return null;
    }

    /**
     * The activity feed for the model
     *
     * @return mixed
     */
    public function activity()
    {
        if (get_class($this) === Project::class) {
            return $this->hasMany(Activity::class)->latest();
        }
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}