<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Table('shielding_requests')]
#[Table(dateFormat: 'Y-m-d')]
class ShieldingRequests extends Model
{
    use SoftDeletes;

    /**
     * Mass assignable attributes
     *
     * @var array<string>
     */
    protected $fillable = [
        'description',
        'request_date',
        'user_id',
        'machine_id',
        'status',
        'completion_date',
        'notes',
    ];

    /*
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'created_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_at' => 'datetime',
            'request_date' => 'date:Y-m-d',
            'completion_date' => 'date:Y-m-d',
        ];
    }

    /*
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    /*
     * Scopes
     */
    #[Scope]
    protected function inProgress(Builder $query): void
    {
        $query->where('status', Status::InProgress);
    }

    #[Scope]
    protected function completed(Builder $query): void
    {
        $query->where('status', Status::Complete);
    }

    #[Scope]
    protected function needInfo(Builder $query): void
    {
        $query->where('status', Status::NeedInfo);
    }
}
