<?php

namespace Database\Factories;

// /** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model=Brand::class;
    public function definition()
    {
            return [
                'sku_name'=>Str::random(10),
                'logo'=>'V1iUo3K1of16EF0rftJNL3dDSXtWtIP8aQpJNiP7.png',
                'photo'=>'V1iUo3K1of16EF0rftJNL3dDSXtWtIP8aQpJNiP7.png',
                'country_id'=>$this->faker->numberBetween(1,4)
            ];

    }


}
