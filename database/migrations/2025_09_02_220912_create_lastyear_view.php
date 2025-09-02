<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
CREATE VIEW lastyear_view (machine_id, survey_id, test_date) AS
SELECT machine_id, testdates.id as survey_id, test_date
FROM testdates
WHERE test_date
BETWEEN MAKEDATE(YEAR(CURDATE())-1, 1) AND MAKEDATE(YEAR(CURDATE()), 1)
AND testdates.deleted_at IS NULL
AND (testdates.type_id=1 OR testdates.type_id=2)
");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lastyear_view');
    }
};
