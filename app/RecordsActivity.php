<?php


namespace App;

use Illuminate\Support\Arr;

trait RecordsActivity
{

    public $oldAttributes = [];

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

    public function recordActivity(string $description)
    {
        $this->activities()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project->id
        ]);
    }

    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }

    protected function activityDescription(string $description)
    {
        if (class_basename($this) !== 'Project') {
            $description = "{$description}_" . strtolower(class_basename($this));
        }
        return $description;
    }

    protected static function getRecordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }
        return ['created', 'updated', 'deleted'];
    }
}
