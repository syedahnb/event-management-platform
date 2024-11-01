<?php

namespace App\Http\Requests\Event;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('create', Event::class);

    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'location' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today', // Date should not be in the past
            'capacity' => 'required|integer|min:1', // Capacity must be a positive integer
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The event title is required.',
            'title.max' => 'The event title may not be greater than 255 characters.',
            'description.max' => 'The description may not be greater than 1000 characters.',
            'location.required' => 'The event location is required.',
            'date.required' => 'The event date is required.',
            'date.after_or_equal' => 'The event date must be today or a future date.',
            'capacity.required' => 'The capacity is required.',
            'capacity.integer' => 'The capacity must be a valid integer.',
            'capacity.min' => 'The capacity must be at least 1.',
        ];
    }
}
