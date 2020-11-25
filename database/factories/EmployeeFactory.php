<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name,
            'position_id' => Position::all()->random()->id,
            'employment_date' => $this->faker->dateTimeThisMonth(),
            'phone_number' => $this->faker->unique()->numerify('+380 (50) ### ## ##'),
            'email' => $this->faker->unique()->email,
            'salary' => $this->faker->randomFloat(3,0,500),
            'photo' => 'storage/uploads/'.$this->faker->image('public/storage/uploads/', 300, 300, null, false),
            'created_at' => $this->faker->dateTimeThisMonth(),
            'updated_at' => $this->faker->dateTimeThisMonth(),
            'admin_created_id' => User::all()->random()->id,
            'admin_updated_id' => User::all()->random()->id
        ];
    }
}
