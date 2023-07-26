<?php

namespace Database\Factories;

use App\Models\Occasion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Occasion>
 */
class OccasionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model=Occasion::class;
    public function definition()
    {
        return [
            'icon'=>$this->faker->image('public/images',640,480, null, false),
        ];
    }
}
