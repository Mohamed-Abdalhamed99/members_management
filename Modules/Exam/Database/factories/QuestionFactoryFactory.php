<?php

namespace Modules\Exam\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Exam\Entities\QuestionFactory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}

