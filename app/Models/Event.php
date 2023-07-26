<?php

namespace App\Models;

use App\Models\Scopes\EventsByOrganizationId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public const MAXIMUM_DURATION_EVENT_IN_HOURS = 12;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'event_start_date' => 'datetime:"Y-m-d H:i:s"',
        'event_end_date' => 'datetime:"Y-m-d H:i:s"',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_title',
        'event_start_date',
        'event_end_date',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new EventsByOrganizationId());
    }
}
