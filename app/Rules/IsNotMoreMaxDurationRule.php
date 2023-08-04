<?php

namespace App\Rules;

use App\Models\Event;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class IsNotMoreMaxDurationRule implements ValidationRule
{
    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     */
    public function __construct(
        private Carbon $startDate,
        private Carbon $endDate
    )
    {
    }

    /**
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->endDate->diffInHours($this->startDate) >= Event::MAXIMUM_DURATION_EVENT_IN_HOURS) {
            $fail('The duration between the event_start_date and event_end_date cannot exceed 12 hours');
        }
    }
}
