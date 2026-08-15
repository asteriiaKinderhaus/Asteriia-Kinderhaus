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
        Schema::create('parents', function (Blueprint $table) {

            $table->char('id', 10)->primary();

            $table->string('name', 50);

            $table->string('address', 100)->nullable();

            $table->string('telephone', 20)->nullable();

            $table->string('email', 50)->nullable();

            $table->char('gender_id', 1);

            $table->char('user_id', 10);

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('gender_id')
                ->references('id')
                ->on('genders')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('user_id')
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
        Schema::dropIfExists('parents');
    }
};
