<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
         * lastyear_view and thisyear_view are created assuming
         * routine and acceptance tests in the testtypes table
         * have ID 1 and 2 respectively.
         * If this is not true, the type_ids will need to be changed
         * accordingly.
         * Should find a better way to do this.
         */
        DB::statement("
CREATE VIEW lastyear_view (machine_id, survey_id, test_date) AS
SELECT machine_id, testdates.id as survey_id, test_date
FROM testdates
WHERE test_date
BETWEEN MAKEDATE(YEAR(CURDATE())-1, 1) AND MAKEDATE(YEAR(CURDATE()), 1)
AND testdates.deleted_at IS NULL
AND (testdates.testtype_id=1 OR testdates.testtype_id=2)
");

        DB::statement("
CREATE VIEW thisyear_view (machine_id, survey_id, test_date) AS
SELECT machine_id, testdates.id as survey_id, test_date
FROM testdates
WHERE testdates.test_date BETWEEN
MAKEDATE(YEAR(CURDATE()), 1) AND MAKEDATE(YEAR(CURDATE())+1, 1)
AND testdates.deleted_at IS NULL
AND (testdates.testtype_id=1 OR testdates.testtype_id=2)
");

        // surveyschedule view
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
        Schema::dropAllViews();
    }
};
