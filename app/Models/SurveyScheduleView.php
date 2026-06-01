<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyScheduleView extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surveyschedule_view';

    /**
     * Eager loaded relationships
     * 
     * @var array
     */
    protected $with = [
        'machine',
        'prevSurvey',
        'currSurvey',
    ];

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
            'prevSurveyDate' => 'date:Y-m-d',
            'currSurveyDate' => 'date:Y-m-d',
        ];
    }

    /*
     * Relationships
     */
    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class, 'id');
    }

    public function prevSurvey(): BelongsTo
    {
        return $this->belongsTo(TestDate::class, 'prevSurveyID');
    }

    public function currSurvey(): BelongsTo
    {
        return $this->belongsTo(TestDate::class, 'currSurveyID');
    }

    /*
     * Scopes
     */

    /**
     * Scope function to return pending surveys (scheduled after the current date).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    #[Scope]
    protected function pending(Builder $query): void
    {
        $query->where('currSurveyDate', '>=', date('Y-m-d'));
    }

    /**
     * Scope function to return machines needing surveys.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    #[Scope]
    protected function surveyNeeded(Builder $query): void
    {
        $query->where('currSurveyDate', null);
    }
    
}
