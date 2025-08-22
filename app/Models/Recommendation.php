<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;

class Recommendation extends Model
{
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'recommendation',
        'resolved',
        'rec_add_ts',
        'rec_resolve_ts',
        'resolved_by',
        'rec_status',
        'wo_number',
    ];

    /*
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'created_at'   => 'datetime',
            'deleted_at'   => 'datetime',
            'updated_at'   => 'datetime',
            'rec_add_ts'     => 'datetime',
            'rec_resolve_ts' => 'datetime',
        ];
    }

    public function registerMediaCollection(): void
    {
        $this->addMediaCollection('service_reports')
            ->useDisk('ServiceReports');
    }

    /*
     * Relationships
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(TestDate::class);
    }
}
