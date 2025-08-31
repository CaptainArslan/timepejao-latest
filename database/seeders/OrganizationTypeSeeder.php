<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Primary',
                'description' => 'Play to 5th',
                'start_class' => 0, // Play
                'end_class' => 5,
            ],
            [
                'name' => 'Middle School',
                'description' => '6th to 8th',
                'start_class' => 6,
                'end_class' => 8,
            ],
            [
                'name' => 'Higher School',
                'description' => '9th to 10th',
                'start_class' => 9,
                'end_class' => 10,
            ],
            [
                'name' => 'College',
                'description' => '11th to 12th',
                'start_class' => 11,
                'end_class' => 12,
            ],
            [
                'name' => 'Higher College',
                'description' => 'Bachelor University',
                'start_class' => null,
                'end_class' => null,
            ],
            [
                'name' => 'University',
                'description' => 'Master Level / PhD',
                'start_class' => null,
                'end_class' => null,
            ],
            [
                'name' => 'Other',
                'description' => 'Private and other organization',
                'start_class' => null,
                'end_class' => null,
            ],
        ];

        foreach ($types as $type) {
            OrganizationType::create($type);
        }
    }
}
