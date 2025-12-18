<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert existing double values to JSON arrays
        // Handle MySQL/MariaDB JSON conversion
        try {
            DB::statement('UPDATE nilai_mahasiswas SET tugas = JSON_ARRAY(COALESCE(tugas, 0)) WHERE tugas IS NOT NULL OR tugas IS NULL');
            DB::statement('UPDATE nilai_mahasiswas SET project = JSON_ARRAY(COALESCE(project, 0)) WHERE project IS NOT NULL OR project IS NULL');
        } catch (\Exception $e) {
            // If JSON_ARRAY doesn't work, use manual conversion
            $nilaiRecords = DB::table('nilai_mahasiswas')->get();
            foreach ($nilaiRecords as $record) {
                $tugasValue = $record->tugas ?? 0;
                $projectValue = $record->project ?? 0;
                DB::table('nilai_mahasiswas')
                    ->where('id', $record->id)
                    ->update([
                        'tugas' => json_encode([(float)$tugasValue]),
                        'project' => json_encode([(float)$projectValue])
                    ]);
            }
        }
        
        Schema::table('nilai_mahasiswas', function (Blueprint $table) {
            $table->json('tugas')->nullable()->change();
            $table->json('project')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Extract first value from JSON array back to double
        try {
            DB::statement('UPDATE nilai_mahasiswas SET tugas = JSON_EXTRACT(tugas, "$[0]") WHERE tugas IS NOT NULL');
            DB::statement('UPDATE nilai_mahasiswas SET project = JSON_EXTRACT(project, "$[0]") WHERE project IS NOT NULL');
        } catch (\Exception $e) {
            // Manual conversion if JSON_EXTRACT doesn't work
            $nilaiRecords = DB::table('nilai_mahasiswas')->get();
            foreach ($nilaiRecords as $record) {
                $tugasArray = json_decode($record->tugas, true);
                $projectArray = json_decode($record->project, true);
                $tugasValue = is_array($tugasArray) && count($tugasArray) > 0 ? $tugasArray[0] : 0;
                $projectValue = is_array($projectArray) && count($projectArray) > 0 ? $projectArray[0] : 0;
                DB::table('nilai_mahasiswas')
                    ->where('id', $record->id)
                    ->update([
                        'tugas' => (float)$tugasValue,
                        'project' => (float)$projectValue
                    ]);
            }
        }
        
        Schema::table('nilai_mahasiswas', function (Blueprint $table) {
            $table->double('tugas')->default(0)->change();
            $table->double('project')->default(0)->change();
        });
    }
};
