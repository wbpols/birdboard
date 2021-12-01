<?php

namespace App\Models\Project;

use App\Models\Activity\Activity;
use App\Models\User\User;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
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
}
