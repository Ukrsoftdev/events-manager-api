<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Validation\UnauthorizedException;

/**
 * @mixin Builder
 * @method null|static first($columns = ['*'])
 *
 * @property-read int $id
 * @property string $event_title
 * @property-read Carbon $event_start_date
 * @property-read Carbon $event_end_date
 *
 * @property-read Organization $organization_id
 * @method static Organization find($id, $columns = ['*'])
 *
 * @method Builder byAuthOrganization()
 */
class Event extends Model
{
    use HasFactory;

    public const MAXIMUM_DURATION_EVENT_IN_HOURS = 12;

    public $timestamps = false;

    protected $casts = [
        'event_start_date' => 'datetime:"Y-m-d H:i:s"',
        'event_end_date' => 'datetime:"Y-m-d H:i:s"',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    protected $fillable = [
        'event_title',
        'event_start_date',
        'event_end_date',
    ];

    public function scopeByAuthOrganization(Builder $query): void
    {
        if (null === $user = auth()->user()) {
            throw new UnauthorizedException();
        }

        $query->where('organization_id', $user->getAuthIdentifier());
    }
}
