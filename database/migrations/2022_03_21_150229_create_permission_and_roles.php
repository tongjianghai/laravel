<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("admin_roles", function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create("admin_permissions", function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create("admin_permission_role", function (Blueprint $table) {
            $table->increments('id');
            $table->integer("role_id");
            $table->integer("permission_id");
            $table->timestamps();
        });

        Schema::create("admin_role_user", function (Blueprint $table) {
            $table->increments('id');
            $table->integer("role_id");
            $table->integer("user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_and_roles');
    }
};
