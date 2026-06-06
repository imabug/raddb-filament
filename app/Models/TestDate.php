<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[Table('test_dates')]
class TestDate extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * Eager loaded relationships
     *
     * @var array
     */
    protected $with = [
        'machine',
        'testType',
    ];

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'machine_id',
        'test_type_id',
        'test_date',
        'accession',
        'notes',
    ];

    /*
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'test_date'  => 'datetime:Y-m-d H:i:s',
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

    public function testType(): BelongsTo
    {
        return $this->belongsTo(TestType::class);
    }

    public function thisYear(): HasOne
    {
        return $this->hasOne(ThisYear::class, 'survey_id');
    }

    public function lastYear(): HasOne
    {
        return $this->hasOne(LastYear::class, 'survey_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    
    /**
     * Scope function to return the test date year
     *
     */
    #[Scope]
    protected function year(Builder $query, int $y): void
    {
        $query->whereYear('test_date', '=', $y);
    }

    /**
     * Scope function to return pending test dates (scheduled after the current date).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    #[Scope]
    protected function pending(Builder $query): void
    {
        $query->where('test_date', '>=', date('Y-m-d'));
    }

    /**
     * Scope function to return the n most recent routine annual survey test dates.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $n
     */
    #[Scope]
    protected function recent(Builder $query, $n): void
    {
        $query->where('test_type_id', 1)
            ->orderby('test_date', 'desc')
            ->limit($n);
    }

    /**
     * Scope function to return surveys for active machines.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     */
    #[Scope]
    protected function activeMachines(Builder $query): void
    {
        $query->whereHas('machine', function ($q) {
            $q->where('machine_status', Status::Active);
        });
    }
}
