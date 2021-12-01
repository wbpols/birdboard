<?php

namespace App\Traits;

use App\Models\Activity\Activity;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * The original attributes of the Model.
     *
     * @var array
     */
    public $oldAttributes = [
        //
    ];


    /*
    |--------------------------------------------------------------------------
    | Boot Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Perform Eloquent actions related to the RecordsActivity trait.
     *
     * @return void
     */
    public static function bootRecordsActivity()
    {
        // Loop through each event and perform the occuring action.
        foreach (self::getRecordableActivityEvents() as $event) {
            static::$event(function ($model) use ($event) {
                // Record the activity.
                $model->record($model->getActivityDescription($event));
            });

            // Set the old attribute values property when updating the model.
            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * The activities for this Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }


    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the before and after changes made to this Model.
     *
     * @param  string  $description  The type of activity.
     * @return array|void
     */
    public function getActivityChanges()
    {
        // Only return an array when the model is updated.
        if ($this->wasChanged()) {
            return [
                "before" => Arr::except(
                    array_diff($this->oldAttributes, $this->getAttributes()),
                    [
                        $this->getCreatedAtColumn(),
                        $this->getUpdatedAtColumn(),
                    ]
                ),
                "after" => Arr::except(
                    $this->getChanges(),
                    [
                        $this->getCreatedAtColumn(),
                        $this->getUpdatedAtColumn(),
                    ]
                ),
            ];
        }
    }

    /**
     * Get the description for an Activity.
     *
     * @param  string  $description
     * @return string
     */
    protected function getActivityDescription(string $description)
    {
        return "{$description}_" . strtolower(basename(static::class));
    }

    /**
     * Get the ID of the owner of the Project for the Activity.
     *
     * @return int
     */
    protected function getActivityOwnerId()
    {
        return basename(static::class) === 'Project'
            ? $this->owner_id
            : $this->project->owner_id;
    }

    /**
     * Create a Activity for the Project.
     *
     * @param  string  $description  A description for the Activity.
     * @return \App\Models\Activity\Activity
     */
    public function record(string $description)
    {
        return $this->activities()->create([
            "description" => $description,
            "changes" => $this->getActivityChanges(),
            "project_id" => basename(static::class) === 'Project' ? $this->id : $this->project_id,
            "user_id" => $this->getActivityOwnerId(),
        ]);
    }

    /**
     * Get the events to record a Activity on.
     *
     * @return array
     */
    protected static function getRecordableActivityEvents()
    {
        return isset(static::$recordableActivityEvents)
            ? static::$recordableActivityEvents
            : ['created', 'updated', 'deleted'];
    }
}
