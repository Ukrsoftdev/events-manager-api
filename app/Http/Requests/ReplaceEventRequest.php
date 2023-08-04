<?php

namespace App\Http\Requests;

use App\Rules\IsEndDateBeforeStartRule;
use App\Rules\IsNotMoreMaxDurationRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

final class ReplaceEventRequest extends FormRequest
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
            'event_title' => [
                'required',
                'max:200',
                'string'
            ],
            'event_start_date' => [
                'required',
                'date'
            ],
            'event_end_date' => [
                'required',
                'date',
                new IsEndDateBeforeStartRule(new Carbon($this->get('event_start_date')), new Carbon($this->get('event_end_date'))),
                new IsNotMoreMaxDurationRule(new Carbon($this->get('event_start_date')), new Carbon($this->get('event_end_date')))
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'event_start_date.date' => 'The value event_start_date must be in datetime format "Y-m-d H:i:s"',
            'event_end_date.date' => 'The value event_end_date must be in datetime format "Y-m-d H:i:s"',
            'event_end_date.before' => ['event_end_date' => 'The value event_end_date can`t be before the event_start_date'],
            'event_end_date.exceed' => ['event_end_date' => 'The duration between the event_start_date and event_end_date cannot exceed 12 hours'],
        ];
    }
}
