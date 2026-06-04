<?php

namespace App\Models;

use App\Enums\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Machine extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * Eager loaded relationships
     *
     * @var array
     */
    protected $with = [
        'facility',
        'location',
        'modality',
        'manufacturer',
        'tube',
        'opnote',
    ];

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'facility_id',
        'location_id',
        'modality_id',
        'manufacturer_id',
        'description',
        'vend_site_id',
        'model',
        'serial_number',
        'manuf_date',
        'install_date',
        'remove_date',
        'room',
        'machine_status',
        'software_version',
        'pacs_station',
        'notes',
    ];

    /*
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'machine_status' => Status::class,
            'created_at'   => 'datetime',
            'deleted_at'   => 'datetime',
            'updated_at'   => 'datetime',
            'manuf_date'   => 'date:Y-m-d',
            'install_date' => 'date:Y-m-d',
            'remove_date'  => 'date:Y-m-d',
        ];
    }

    /**
     * Accessors to append to the model.
     *
     * @var array<string>
     */
    protected $appends = ['age'];

    public function registerMediaCollections(?Media $media = null): void
    {
        $this->addMediaCollection('machine_photos')
            ->useDisk('MachinePhotos');
    }

    /*
     * Relationships
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function modality(): BelongsTo
    {
        return $this->belongsTo(Modality::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function tube(): HasMany
    {
        return $this->hasMany(Tube::class);
    }

    public function opnote(): HasMany
    {
        return $this->hasMany(OpNote::class);
    }

    public function testdate(): HasMany
    {
        return $this->hasMany(TestDate::class);
    }

    public function thisyear(): HasMany
    {
        return $this->hasMany(ThisYear::class);
    }

    public function lastyear(): HasMany
    {
        return $this->hasMany(LastYear::class);
    }

    public function testdateRecent(): HasMany
    {
        return $this->hasMany(TestDate::class)
            ->latest('test_date')->first();
    }

    public function surveySchedule(): HasOne
    {
        return $this->hasOne(SurveyScheduleView::class, 'id');
    }

    /*
     * Scopes
     */

    /**
     * Scope function to return active machines
     */
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('machine_status', Status::Active);
    }

    /**
     * Scope function to return inactive machines
     */
    #[Scope]
    protected function inactive(Builder $query): void
    {
        $query->where('machine_status', Status::Inactive);
    }

    /**
     * Scope function to return removed machines
     */
    #[Scope]
    protected function removed(Builder $query): void
    {
        $query->where('machine_status', Status::Removed);
    }

    /**
     * Scope function to return test equipment
     */
    #[Scope]
    protected function testEquipment(Builder $query): void
    {
        // If the modality_id for test equipment is something other than 19
        // change the value in the where clause appropriately
        $query->where('modality_id', 19);
    }

    /*
     * Mutators
     */

    /**
     * Add an age attribute based on either install or manufacture date.
     */
    protected function age(): Attribute
    {
        // Calculate the age of the unit based on manuf_date or install_date
        return Attribute::make(
            get: function ($value, $attributes) {
                if (!is_null($attributes['manuf_date'])) {
                    return Carbon::createFromFormat('Y-m-d', $attributes['manuf_date'])->age;
                } elseif (!is_null($attributes['install_date'])) {
                    return Carbon::createFromFormat('Y-m-d', $attributes['install_date'])->age;
                }
            },
        );
    }
}
