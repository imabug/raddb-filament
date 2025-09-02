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
CREATE VIEW surveyschedule_view (id, description, prevSurveyId, prevSurveyDate, currSurveyId, currSurveyDate) AS
SELECT machines.id, machines.description,
lastyear_view.survey_id as prevSurveyId, lastyear_view.test_date as prevSurveyDate,
thisyear_view.survey_id as currSurveyId, thisyear_view.test_date as currSurveyDate
FROM machines
LEFT JOIN thisyear_view on machines.id = thisyear_view.machine_id
LEFT JOIN lastyear_view on machines.id = lastyear_view.machine_id
WHERE machines.machine_status='Active'
ORDER BY prevSurveyDate, id ASC
");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveyschedule_view');
    }
};
