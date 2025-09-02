<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThisYear extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'thisyear_view';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'survey_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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
        return $this->belongsTo(\App\Models\Machine::class, 'machine_id');
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(TestDate::class, 'survey_id');
    }
}
