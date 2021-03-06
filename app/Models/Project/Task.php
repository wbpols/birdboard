<?php

namespace App\Models\Project;

use App\Models\Activity\Activity;
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
        $this->update(["completed" => $completed]);
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

    /**
     * Create a Activity for the Project.
     *
     * @param  string  $description  A description for the Activity.
     * @return \App\Models\Activity\Activity
     */
    public function record(string $description)
    {
        return $this->activities()->create([
            "project_id" => $this->project_id,
            "description" => $description,
        ]);
    }
}
