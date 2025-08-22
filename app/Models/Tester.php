<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tester extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['name', 'initials'];

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
