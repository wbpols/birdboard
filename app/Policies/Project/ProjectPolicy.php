<?php

namespace App\Policies\Project;

use App\Models\Project\Project;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Project\Project  $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        // Validate that the authenticated User is the owner of the Project.
        return $user->is($project->owner);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Project\Project  $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        // Validate that the authenticated User is the owner of the Project.
        return $user->is($project->owner);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Project\Project  $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Project\Project  $project
     * @return mixed
     */
    public function restore(User $user, Project $project)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User\User  $user
     * @param  \App\Models\Project\Project  $project
     * @return mixed
     */
    public function forceDelete(User $user, Project $project)
    {
        //
    }
}
