<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Project;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Specifies the model of the factory
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reportable_id' => Device::factory(),
            'reportable_type' => 'device',
            'format' => $this->faker->randomElement(['PDF', 'CSV']),
            'content' => $this->faker->paragraph,
        ];
    }
}
