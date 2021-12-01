<?php

namespace App\Models\Project;

use App\Models\Activity\Activity;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */
    use HasFactory;
    use RecordsActivity;


    /*
    |--------------------------------------------------------------------------
    | Model Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "project_id" => "integer",
        "completed" => "boolean",
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        //
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = [
        "project",
    ];


    /*
    |--------------------------------------------------------------------------
    | Custom Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * The events that should be recorded on a Activity.
     *
     * @var string[]
     */
    protected static $recordableActivityEvents = [
        'created',
        'deleted',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * The project related to this Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Custom Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Mark the Task as completed.
     *
     * @param  bool  $completed  Variable used to
     * @return void
     */
    public function complete($completed = true)
    {
        // Update the task.
        $this->update(["completed" => $completed]);

        // Record the changes.
        $this->record(($completed ? 'completed' : 'uncompleted') . '_task');
    }

    /**
     * Revert the Task back to uncompleted.
     *
     * @return void
     */
    public function uncomplete()
    {
        $this->complete(false);
    }

    /**
     * The route to 'show' this Model.
     *
     * @return string
     */
    public function path()
    {
        return "/{$this->project->getTable()}/{$this->project->getRouteKey()}/{$this->getTable()}/{$this->getKey()}";
    }
}
