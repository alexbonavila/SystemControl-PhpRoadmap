<?php

namespace Database\Factories;

use App\Models\Configuration;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Configuration>
 */
class ConfigurationFactory extends Factory
{
    /**
     * Specifies the model of the factory
     */
    protected $model = Configuration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id' => Device::factory(),
            'cpu' => $this->faker->randomElement(['Intel', 'AMD']),
            'ram' => $this->faker->numberBetween(4, 64) . 'GB',
            'storage' => $this->faker->numberBetween(128, 2048) . 'GB',
        ];
    }
}
