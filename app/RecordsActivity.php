<?php


namespace App;

use Illuminate\Support\Arr;

trait RecordsActivity
{

    /**
     * Save the ols attributes
     *
     * @var array
     */
    public $oldAttributes = [];

    /**
     * Boot trait.
     */
    public static function bootRecordsActivity()
    {
        foreach (self::getRecordableEvents() as $event) {

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

    /**
     * Persist activity.
     *
     * @param string $description
     */
    public function recordActivity(string $description)
    {
        $this->activities()->create([
            'user_id' => ($this->project ?? $this)->owner_id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project->id
        ]);
    }

    /**
     * Array of changes.
     *
     * @return array
     */
    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }

    /**
     * Activity description.
     *
     * @param string $description
     * @return string
     */
    protected function activityDescription(string $description)
    {
        return "{$description}_" . strtolower(class_basename($this));
    }

    /**
     * Recordable events. It's possible to rewrite in model.
     *
     * @return array
     */
    protected static function getRecordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }
        return ['created', 'updated', 'deleted'];
    }
}
