<?php

namespace App\Http\Requests;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ReplaceEventRequest extends FormRequest
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
            'event_title' => ['required'],
            'event_start_date' => ['required', 'date'],
            'event_end_date' => ['required', 'date'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'event_title.required' => 'The value event_title is required',
            'event_start_date.required' => 'The value event_start_date is required',
            'event_end_date.required' => 'The value event_end_date is required',
            'event_start_date.date' => 'The value event_start_date must be in datetime format "Y-m-d H:i:s"',
            'event_end_date.date' => 'The value event_end_date must be in datetime format "Y-m-d H:i:s"',
            'event_end_date.before' => ['event_end_date' => 'The value event_end_date can`t be before the event_start_date'],
            'event_end_date.exceed' => ['event_end_date' => 'The duration between the event_start_date and event_end_date cannot exceed 12 hours'],
        ];
    }

    /**
     * @return void
     */
    protected function passedValidation(): void
    {
        $start = new Carbon($this->get('event_start_date'));
        $end = new Carbon($this->get('event_end_date'));

        if ($end->isBefore($start)) {
            throw ValidationException::withMessages([$this->messages()['event_end_date.before']]);
        }

        if ($end->diffInHours($start) >= Event::MAXIMUM_DURATION_EVENT_IN_HOURS) {
            throw ValidationException::withMessages([$this->messages()['event_end_date.exceed']]);
        }
    }
}
