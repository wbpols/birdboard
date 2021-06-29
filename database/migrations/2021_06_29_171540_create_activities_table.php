<?php

use App\Models\Project\Project;
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

        Schema::create('activities', function (Blueprint $table) use ($project) {
            $table->id();
            $table->unsignedBigInteger('project_id')
                ->comment("References the {$project->getKeyName()} on '{$project->getTable()}'");
            $table->string('description');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('project_id')
                ->references($project->getKeyName())
                ->on($project->getTable())
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
