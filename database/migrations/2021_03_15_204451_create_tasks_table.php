<?php

use App\Models\Project\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $project = new Project();

        Schema::create('tasks', function (Blueprint $table) use ($project) {
            $table->id();
            $table->unsignedBigInteger($project->getForeignKey());
            $table->text('body');
            $table->boolean('completed')->default(false);
            $table->timestamps();

            // Foreign Keys
            $table->foreign($project->getForeignKey())
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
        Schema::dropIfExists('tasks');
    }
}
