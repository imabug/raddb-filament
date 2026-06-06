<?php

namespace App\Models;

use App\Models\Machine;
use App\Models\TestDate;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('lastyear_view', key: 'survey_id', incrementing: false)]
class LastYear extends Model
{
    /*
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'test_date' => 'date:Y-m-d H:i:s',
        ];
    }

    /*
     * Relationships
     */

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(TestDate::class, 'survey_id');
    }
}
