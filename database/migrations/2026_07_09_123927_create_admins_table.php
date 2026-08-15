<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {

            $table->char('id', 10);

            $table->string('name', 50);

            $table->string('telephone', 20)->nullable();

            $table->string('address', 100)->nullable();

            $table->string('email', 50)->nullable();

            $table->char('users_id', 10);

            $table->primary('id');

            $table->foreign('users_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
