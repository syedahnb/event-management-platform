<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'location' => $this->faker->address,
            'date' => $this->faker->date('Y-m-d', '+2 months'),
            'capacity' => $this->faker->numberBetween(10, 100),
            'is_full' => false,
        ];
    }
}
