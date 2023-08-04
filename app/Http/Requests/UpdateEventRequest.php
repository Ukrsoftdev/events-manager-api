<?php

namespace App\Http\Requests;

use App\Models\Event;
use App\Rules\IsEndDateBeforeStartRule;
use App\Rules\IsNotMoreMaxDurationRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateEventRequest extends FormRequest
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
                'filled',
                'max:200',
                'string',
                'required_without_all:event_start_date,event_end_date'
            ],
            'event_start_date' => [
                'filled', 'date',
                'required_without_all:event_title,event_end_date',
                request()->has('event_end_date') ? null : new IsEndDateBeforeStartRule($this->getDateByKey('event_start_date'), $this->getDateByKey('event_end_date')),
                request()->has('event_end_date') ? null : new IsNotMoreMaxDurationRule($this->getDateByKey('event_start_date'), $this->getDateByKey('event_end_date'))
            ],
            'event_end_date' => [
                'filled',
                'date',
                'required_without_all:event_title,event_start_date',
                new IsEndDateBeforeStartRule($this->getDateByKey('event_start_date'), $this->getDateByKey('event_end_date')),
                new IsNotMoreMaxDurationRule($this->getDateByKey('event_start_date'), $this->getDateByKey('event_end_date'))
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

    /**
     * @param string $key
     * @return Carbon
     */
    private function getDateByKey(string $key): Carbon
    {
        if (request()->has($key)) {
            return new Carbon(request()->all()[$key]);
        }

        /** @var Event $event */
        $event = $this->event;

        return $event->getAttribute($key);
    }
}
