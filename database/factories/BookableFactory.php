<?php

namespace Database\Factories;

use App\Models\Bookable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class BookableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookable::class;
    protected $suffix = [
        'Villa',
        'House',
        'Cottage',
        'Rooms',
        'Fancy Rooms'
    ];
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->city() . ' ' . Arr::random($this->suffix),
            'description' => $this->faker->text(),
            'price' => random_int(50, 670)
        ];
    }
}
