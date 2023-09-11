<?php

namespace Modules\Student\Database\factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'mobile' => $this->faker->phoneNumber(),
            'code' => rand(100000000 , 999999999),
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address(),
            'join_date' => $this->faker->date(),
            'status' => 1,
        ];
    }
}

