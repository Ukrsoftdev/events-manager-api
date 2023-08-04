<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class IsEndDateBeforeStartRule implements ValidationRule
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
        if ($this->endDate->isBefore($this->startDate)) {
            $fail('The event_end_date can`t be before the event_start_date');
        }
    }
}
