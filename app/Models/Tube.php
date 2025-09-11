<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tube extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'machine_id',
        'housing_manuf_id',
        'housing_model',
        'housing_sn',
        'insert_manuf_id',
        'insert_model',
        'insert_sn',
        'manuf_date',
        'install_date',
        'remove_date',
        'lfs',
        'mfs',
        'sfs',
        'notes',
        'tube_status',
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

    /*
     * Relationships
     */
    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function housing_manuf(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function insert_manuf(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    /*
     * Mutators
     */

    /**
     * Add an age attribute based on either install or manufacture date.
     */
    public function age(): Attribute
    {
        // Calculate the age of the unit based on manuf_date or install_date
        return Attribute::make(
            get: function ($value, $attributes) {
                if (!is_null($attributes['manuf_date'])) {
                    return Carbon::createFromFormat('Y-m-d', $attributes['manuf_date'])->age;
                } elseif (!is_null($attributes['install_date'])) {
                    return Carbon::createFromFormat('Y-m-d', $attributes['install_date'])->age;
                }
            }
        );
    }
}
