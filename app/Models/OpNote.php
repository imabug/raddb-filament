<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpNote extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'opnotes';

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'machine_id',
        'note',
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
        ];
    }

    // Relationships
    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }
}
