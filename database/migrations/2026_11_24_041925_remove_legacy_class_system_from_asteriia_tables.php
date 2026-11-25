
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus sistem kelas lama.
     */
    public function up(): void
    {
        // 1. Hapus foreign key students.class_id
        if (Schema::hasTable('students') &&
            Schema::hasColumn('students', 'class_id')) {

            Schema::table('students', function (Blueprint $table) {
                $table->dropForeign('students_class_id_foreign');
            });

            // 2. Hapus kolom students.class_id
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('class_id');
            });
        }

        // 3. Hapus tabel penghubung fasilitator-kelas
        Schema::dropIfExists('facilitator_class');

        // 4. Hapus tabel kelas
        Schema::dropIfExists('school_classes');
    }

    /**
     * Membuat kembali struktur sistem kelas lama.
     *
     * Catatan: data lama tidak dipulihkan otomatis.
     */
    public function down(): void
    {
        // 1. Buat kembali tabel school_classes
        if (!Schema::hasTable('school_classes')) {
            Schema::create('school_classes', function (Blueprint $table) {
                $table->char('id', 10)->primary();
                $table->string('name', 50);
                $table->unsignedInteger('capacity')->default(20);
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // 2. Buat kembali tabel facilitator_class
        if (!Schema::hasTable('facilitator_class')) {
            Schema::create('facilitator_class', function (Blueprint $table) {
                $table->string('facilitator_id', 10);
                $table->string('class_id', 10);
                $table->timestamps();

                $table->primary([
                    'class_id',
                    'facilitator_id'
                ]);

                $table->unique([
                    'facilitator_id',
                    'class_id'
                ]);

                $table->foreign('facilitator_id')
                    ->references('id')
                    ->on('facilitators')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->foreign('class_id')
                    ->references('id')
                    ->on('school_classes')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
        }

        // 3. Buat kembali students.class_id
        // Nullable agar tidak mengganggu data peserta didik yang sudah ada.
        if (Schema::hasTable('students') &&
            !Schema::hasColumn('students', 'class_id')) {

            Schema::table('students', function (Blueprint $table) {
                $table->char('class_id', 10)
                    ->nullable()
                    ->after('gender_id');

                $table->foreign('class_id')
                    ->references('id')
                    ->on('school_classes')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            });
        }
    }
};
