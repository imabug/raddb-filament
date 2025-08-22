<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestType extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testtypes';

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['test_type'];

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
    public function testdate(): HasMany
    {
        return $this->hasMany(TestDate::class);
    }
}
