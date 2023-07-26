<?php

namespace App\Http\Requests;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateEventRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'event_title' => ['filled'],
            'event_start_date' => ['filled', 'date'],
            'event_end_date' => ['filled', 'date'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'event_title.filled' => 'The value event_title can`t be empty',
            'event_start_date.filled' => 'The value event_start_date can`t be empty',
            'event_end_date.filled' => 'The value event_end_date can`t be empty',
            'event_start_date.date' => 'The value event_start_date must be in datetime format "Y-m-d H:i:s"',
            'event_end_date.date' => 'The value event_end_date must be in datetime format "Y-m-d H:i:s"',
            'event_end_date.before' => ['event_end_date' => 'The value event_end_date can`t be before the event_start_date'],
            'event_end_date.exceed' => ['event_end_date' => 'The duration between the event_start_date and event_end_date cannot exceed 12 hours'],
        ];
    }

    /**
     * @return void
     * @throws ValidationException
     */
    protected function passedValidation(): void
    {
        $start = $this->getDateValueByKeyFromModel('event_start_date');
        $end = $this->getDateValueByKeyFromModel('event_end_date');

        if ($end->isBefore($start)) {
            throw ValidationException::withMessages(['event_end_date' => 'The value event_end_date can`t be before the event_start_date',]);
        }

        if ($end->diffInHours($start) >= Event::MAXIMUM_DURATION_EVENT_IN_HOURS) {
            throw ValidationException::withMessages(['event_end_date' => 'The duration between the event_start_date and event_end_date cannot exceed 12 hours',]);
        }
    }

    /**
     * @param string $key
     * @return Carbon
     */
    private function getDateValueByKeyFromModel(string $key): Carbon
    {
        if ($this->{$key}) {
            return new Carbon($this->{$key});
        }

        /** @var Event $event */
        $event = $this->event;

        return $event->getAttribute($key);
    }
}
