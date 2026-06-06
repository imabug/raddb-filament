<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('thisyear_view', key: 'survey_id', incrementing: false)]
class ThisYear extends Model
{
    /*
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'test_date' => 'date:Y-m-d',
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
