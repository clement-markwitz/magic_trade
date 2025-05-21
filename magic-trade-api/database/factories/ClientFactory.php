<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->fake()->name();
        $last_name = $this->fake()->last_name();
        $email = $this->fake()->email();
        $user=User::create([
            "name"=> $name." ".$last_name,
            "email"=> $email,
            "password"=> Hash::make("Password2023!"),
        ]);
        return [
            'user_id'=>$user->id,
            'name'=>$name,
            'last_name'=> $last_name,
            'email'=> $email,
            'pseudo'=>$this->fake()->pseudo(),
            'contry'=> $this->fake()->contry(),
            'city'=> $this->fake()->city(),
            'street'=> $this->fake()->street(),
            'postal_code'=> $this->fake()->postcode(),
            'phone'=> $this->fake()->phone(),
            'description'=> $this->fake()->description(),
        ];
    }
}
