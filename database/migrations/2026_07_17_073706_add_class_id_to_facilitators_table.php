<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilitators', function (Blueprint $table) {

            $table->char('class_id', 10)
                ->nullable()
                ->after('gender_id');

            $table->foreign('class_id')
                ->references('id')
                ->on('school_classes')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('facilitators', function (Blueprint $table) {

            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
        });
    }
};
