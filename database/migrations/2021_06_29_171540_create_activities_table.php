<?php

use App\Models\Project\Project;
use App\Models\User\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Define the foreign model relations.
        $project = new Project();
        $user = new User();

        Schema::create('activities', function (Blueprint $table) use ($project, $user) {
            $table->id();
            $table->unsignedBigInteger('project_id')
                ->comment("References the {$project->getKeyName()} on '{$project->getTable()}'");
            $table->unsignedBigInteger('user_id')
                ->comment("References the {$user->getKeyName()} on '{$user->getTable()}'");
            $table->string('subject_type')
                ->nullable(true);
            $table->unsignedBigInteger('subject_id')
                ->nullable(true)
                ->comment("References the ID on the provided 'subject_type' model table");
            $table->string('description');
            $table->text('changes')->nullable(true);
            $table->timestamps();

            // Indexes
            $table->index(["subject_type", "subject_id"], 'activities_subject_index');

            // Foreign Keys
            $table->foreign('project_id')
                ->references($project->getKeyName())
                ->on($project->getTable())
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references($user->getKeyName())
                ->on($user->getTable())
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
