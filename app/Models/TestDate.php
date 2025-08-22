<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TestDate extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testdates';

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'test_date',
        'report_sent_date',
        'notes',
        'accession',
        'report_file_path',
    ];

    /*
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'test_date'  => 'date:Y-m-d',
            'created_at'   => 'datetime',
            'deleted_at'   => 'datetime',
            'updated_at'   => 'datetime',
        ];
    }

    public function registerMediaCollections(?Media $media = null): void
    {
        $this->addMediaCollection('survey_reports')
            ->useDisk('SurveyReports');
    }

    /*
     * Relationships
     */
    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TestType::class);
    }

    public function tester1(): BelongsTo
    {
        return $this->belongsTo(Tester::class);
    }

    public function tester2(): BelongsTo
    {
        return $this->belongsTo(Tester::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class, 'survey_id');
    }

    public function thisyear(): BelongsTo
    {
        return $this->belongsTo(ThisYear::class, 'survey_id');
    }

    public function lastyear(): BelongsTo
    {
        return $this->belongsTo(LastYear::class, 'survey_id');
    }

    /**
     * Scope function to return pending test dates (scheduled after the current date).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    #[Scope]
    public function pending($query): Builder
    {
        return $query->where('testdates.test_date', '>=', date('Y-m-d'));
    }

    /**
     * Scope function to return the n most recent routine annual survey test dates.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $n
     */
    #[Scope]
    public function recent($query, $n): Builder
    {
        return $query->where('type_id', 1)
            ->orderby('test_date', 'desc')
            ->limit($n);
    }
}
