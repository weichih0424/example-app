<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Title;
use Illuminate\Support\Str;

class TitleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model=Title::class;


    public function definition()
    {
        return[
            'text' => $this->faker->realText(10),
            'img' => "01B0".rand(1,4).".jpg",
            'sh' => 0,
        ];
    }
}
