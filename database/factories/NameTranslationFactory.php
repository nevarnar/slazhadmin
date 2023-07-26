<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Category;
use App\Models\Occasion;
use App\Models\NameTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NameTranslation>
 */
class NameTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * 
     */

     protected $model=NameTranslation::class;
    public function definition()
    {
        $name_translationable=$this->name_translationable();
        return [
            'name'=>$this->faker->text,
            'language_code'=>$this->faker->randomElement(['em','mm']),
            'name_translationable_id'=>$name_translationable::factory(),
            'name_translationable_type'=>array_search($name_translationable,Relation::$morphMap),
        ];
    }
    public function name_translationable()
    {
        return $this->faker->randomElement([
            Brand::class,
            Category::class,
            Color::class,
            Occasion::class,
        ]);
    }
}
