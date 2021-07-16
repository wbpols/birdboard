<?php

namespace App\Models\Project;

use App\Models\Activity\Activity;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Project extends Model
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
        "owner_id" => "integer",
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        //
    ];


    /*
    |--------------------------------------------------------------------------
    | Custom Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * The original attributes of the Model.
     *
     * @var array
     */
    public $old = [
        //
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
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * The owner of this Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * The tasks of this Model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Custom Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the before and after changes made to this Model.
     *
     * @param  string  $description  The type of activity.
     * @return array|void
     */
    public function getActivityChanges(string $description)
    {
        // Only return an array when the model is updated.
        if ($description === "updated") {
            return [
                "before" => Arr::except(
                    array_diff($this->old, $this->getAttributes()),
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
     * The route to 'show' this Model.
     *
     * @return string
     */
    public function path()
    {
        return "/{$this->getTable()}/{$this->getKey()}";
    }

    /**
     * Add a new Task Model to the Project.
     *
     * @param  string  $body  The body of the task to create.
     * @return \App\Models\Project\Task
     */
    public function addTask(string $body)
    {
        return $this->tasks()->create(compact("body"));
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
            "changes" =>  $this->getActivityChanges($description)
        ]);
    }
}
