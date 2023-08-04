<?php

namespace App\Models;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\UnauthorizedException;

class Event extends Model
{
    use HasFactory;

    public const MAXIMUM_DURATION_EVENT_IN_HOURS = 12;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
        'event_start_date' => 'datetime:"Y-m-d H:i:s"',
        'event_end_date' => 'datetime:"Y-m-d H:i:s"',
    ];

    /**
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * @var string[]
     */
    protected $fillable = [
        'event_title',
        'event_start_date',
        'event_end_date',
    ];

    /**
     * @param Builder $query
     * @return void
     * @throws AuthenticationException
     */
    public function scopeByOrganization(Builder $query): void
    {
        if (null === $user = auth()->user()) {
            throw new UnauthorizedException();
        }

        $query->where('organization_id', $user->getAuthIdentifier());
    }
}
